<?php

namespace app\action\admin;

use app\service\Fs\FS;
use app\service\Storage\SyncStorage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

class SyncmanualActions
{
    private static function loadedFiles()
    {
        $loadedFiles = [];
        $path        = ROOT . env("SYNC_PATH") . 'unzipped/';
        $files       = FS::files($path, 'xml');
        $loaded = [];
        foreach ($files as $file) {
            if (str_ends_with($file, env("SYNC_OFFER_FILE"))) {
                $loaded[]='offer';
            }
            if (str_ends_with($file, env("SYNC_IMPORT_FILE"))) {
                $loaded[]='import';
            }
        }
        return $loaded;
    }

    public static function unploadFile($files): bool
    {
        [$debugString, $file, $name, $path] = self::vars($files);

        try {
            self::moveFile($file, $path, $name);
            $loadedFiles = self::loadedFiles();
            response()->json(['popup' => 'Файл загружен успешно',
                'bottom' => 'файл загружен',
                'loadedFiles' => $loadedFiles,]);
        } catch (Throwable $exception) {
            $exc = $exception->getMessage();
            response()->json(['popup' => $debugString . ' error: ' . $exc]);
        }
    }

    public static function deleteAllFiles(SyncStorage $store): void
    {
        $dir   = $store::getUnzippedDir();
        $files = $store->getFiles($dir);
        foreach ($files as $file) {
            unlink($file);
        }
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

    public static function vars(array|UploadedFile $file): array
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
        $mime  = $file->getClientOriginalExtension();

        $debugString = "name $name size $size mime $mime error $error filesize $filesize postmaxsize $postmaxsize";
        return [$debugString, $file, $name, $path];

    }
}

