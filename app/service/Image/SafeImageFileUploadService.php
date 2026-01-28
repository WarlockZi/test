<?php

namespace app\service\Image;

use app\service\Fs\FS;
use Exception;
use Illuminate\Http\UploadedFile;

class SafeImageFileUploadService
{
    private $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
    ];

    private $allowedExtensions = [
        'jpg', 'jpeg', 'png', 'webp', 'gif'
    ];
    private string $PIC_BASE_PATH;

    public function __construct(
    )
    {
        $this->PIC_BASE_PATH = env('PIC_BASE_PATH');
    }

    /**
     * @throws Exception
     */
    public function safeUpload(UploadedFile $uploadedFile, string $storagePath): array
    {

//        $safeFilename = $this->generateSafeFilename($extension);
        $storagePath = $this->PIC_BASE_PATH . $storagePath.'/';

        $path = FS::platformSlashes(ROOT.$storagePath. $safeFilename);

        return [
            'path' => $path,
            'safe_filename' => $safeFilename,
        ];
    }

    private function generateSafeFilename($extension): string
    {
        return md5(uniqid() . microtime()) . '.' . $extension;
    }
}