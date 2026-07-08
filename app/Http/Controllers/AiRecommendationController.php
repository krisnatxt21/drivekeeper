<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiRecommendationController extends Controller
{
    // URL FastAPI
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('AI_SERVICE_URL', 'http://127.0.0.1:8001');
    }

    // Tampilkan halaman rekomendasi
    public function index()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('ai.index', compact('vehicles'));
    }

    // Proses prediksi
    public function predict(Request $request)
    {
        $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'vehicle_type'  => 'required|in:motor,mobil',
            'oil_type'      => 'required|string',
            'road_condition'=> 'required|string',
            'usage_type'    => 'required|string',
            'avg_km_per_day'=> 'required|integer|min:1',
        ]);

        // Ambil data kendaraan
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        abort_if($vehicle->user_id !== auth()->id(), 403);

        // Ambil servis terakhir
        $lastService = ServiceRecord::where('vehicle_id', $vehicle->id)
            ->latest('service_date')
            ->first();

        if (!$lastService) {
            return back()->with('error', 'Kendaraan ini belum memiliki riwayat servis. Tambahkan servis terlebih dahulu.');
        }

        // Kirim request ke FastAPI
        try {
            $response = Http::timeout(10)->post("{$this->apiUrl}/predict", [
                'vehicle_type'    => $request->vehicle_type,
                'brand'           => $vehicle->brand,
                'year'            => $vehicle->year,
                'oil_type'        => $request->oil_type,
                'road_condition'  => $request->road_condition,
                'usage_type'      => $request->usage_type,
                'current_odometer'=> $vehicle->odometer,
                'avg_km_per_day'  => $request->avg_km_per_day,
                'last_service_km' => $lastService->odometer,
                'last_service_type'=> $lastService->service_type,
                'last_service_date'=> $lastService->service_date->format('Y-m-d'),
            ]);

            if ($response->successful()) {
                $result = $response->json();
                return view('ai.result', compact('result', 'vehicle', 'lastService'));
            }

            return back()->with('error', 'AI service error: ' . $response->status());

        } catch (\Exception $e) {
            return back()->with('error', 'Tidak dapat terhubung ke AI service. Pastikan server AI berjalan.');
        }
    }
}
