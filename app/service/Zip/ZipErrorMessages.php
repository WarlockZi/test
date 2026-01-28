<?php

namespace app\service\Zip;

use ZipArchive;

trait ZipErrorMessages
{
    protected function getZipErrorMessage(int $errorCode): string
    {
        static $errors = null;

        if ($errors === null) {
            $errors = [
                ZipArchive::ER_EXISTS => 'File already exists',
                ZipArchive::ER_INCONS => 'Zip archive inconsistent',
                ZipArchive::ER_INVAL => 'Invalid argument',
                ZipArchive::ER_MEMORY => 'Malloc failure',
                ZipArchive::ER_NOENT => 'No such file',
                ZipArchive::ER_NOZIP => 'Not a zip archive',
                ZipArchive::ER_OPEN => 'Can\'t open file',
                ZipArchive::ER_READ => 'Read error',
                ZipArchive::ER_SEEK => 'Seek error',
            ];
        }

        return $errors[$errorCode] ?? 'Unknown zip error';
    }

}