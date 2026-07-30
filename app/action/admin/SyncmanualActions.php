<?php

namespace app\action\admin;

use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

class SyncmanualActions
{
    public function __construct(private readonly SyncLogger $logger)
    {
    }

    public static function moveFile(array|UploadedFile $file, string $path, string $name): bool
    {
        try {
            if (is_array($file)) {
                move_uploaded_file($file['tmp_name'], ROOT . $path . $name);
            } else {
                $file->move(FS::platformSlashes(ROOT . $path), $name);
            }
            return true;
        } catch (Throwable $exception) {
            $exc = $exception;
            return false;
        }
    }

    public static function vars(array|UploadedFile $file)
    {
        $path        = env('SYNC_PATH') . 'unzipped/';
        $filesize    = ini_get('upload_max_filesize');
        $postmaxsize = ini_get('post_max_size');

        if (is_array($file)) {
            $name  = $file['name'];
            $size  = $file['size'];
            $error = $file['error'];
            $mime  = $file['type'];

            $debugString = "name $name sieze $size mime $mime error $error filesize $filesize postmaxsize $postmaxsize";
            return [$debugString, $file, $name, $path];
        }

        $name  = $file->getClientOriginalName();
        $size  = $file->getSize();
        $error = $file->getError();
        $mime  = $file->getClientMimeType();

        $debugString = "name $name size $size mime $mime error $error filesize $filesize postmaxsize $postmaxsize";
        return [$debugString, $file, $name, $path];

    }
}

