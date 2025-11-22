<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Aquí defines el disco por defecto que Laravel usará.
    | Puedes cambiarlo a "cloudinary" si quieres usarlo como almacenamiento principal.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Puedes definir múltiples discos (local, públicos o en la nube).
    | Cada uno tiene su propia configuración independiente.
    |
    | Drivers soportados: "local", "ftp", "sftp", "s3", "cloudinary"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'cloudinary' => [
            'driver' => 'cloudinary',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Aquí defines los enlaces simbólicos que Laravel creará con `storage:link`.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
