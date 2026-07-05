<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::whereHas('vehicle', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('vehicle')->latest()->get();

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('documents.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'title'      => 'required|string|max:100',
            'file'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'expired_at' => 'nullable|date',
            'notes'      => 'nullable|string',
        ]);

        // Simpan file ke storage
        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'vehicle_id' => $request->vehicle_id,
            'title'      => $request->title,
            'file_path'  => $path,
            'expired_at' => $request->expired_at,
            'notes'      => $request->notes,
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil diupload!');
    }

    public function destroy(Document $document)
    {
        abort_if($document->vehicle->user_id !== auth()->id(), 403);

        // Hapus file dari storage
        \Storage::disk('public')->delete($document->file_path);

        $document->delete();
        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus!');
    }
}
