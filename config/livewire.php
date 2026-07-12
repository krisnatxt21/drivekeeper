<?php

return [
    'layout' => 'components.layouts.app',
    'inject_assets' => true,
    'inject_morph_markers' => true,
    'legacy_model_binding' => false,
    'morphdom' => 'morphdom',
    'max_file_upload_size' => 12000, // in kilobytes
    'temporary_file_upload_directory' => 'livewire-tmp',
    'render_on_redirect' => false,
    'redirect_using_route_name' => false,
];
