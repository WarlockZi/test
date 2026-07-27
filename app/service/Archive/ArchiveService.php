<?php

namespace app\service\Archive;

class ArchiveService
{
    private string $archiveFilePath;
    private string $toPath;

    public function archiveFilePath(string $archiveFilePath): self
    {
        $this->archiveFilePath = $archiveFilePath;
        return $this;
    }

    public function toPath(string $toPath): self
    {
        $this->toPath = $toPath;
        return $this;
    }

    private function transformOutput($output)
    {
        if (!$output) return '';
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $output = array_map(function ($line) {
                return iconv('CP866', 'UTF-8//IGNORE', $line);
            }, $output);
        }
        return $output;
    }

    public function extract(): void
    {
        $this->checkFromTo();

        $returnCode = 0;
        $output     = [];

        $command = sprintf("7z e %s -o%s -y -aoa 2>&1",
            escapeshellarg($this->archiveFilePath),
            escapeshellarg($this->toPath)
        );

        exec($command, $output, $returnCode);
        $output = $this->transformOutput($output);

        if ($returnCode !== 0) {
            $lastError = implode("\n", $output);
            response()->popup($lastError);
        }
        response()->popup('Файлы разархивированы. Можно загружать.');
    }

    private function checkFromTo(): void
    {
        if (!$this->toPath) {
            response()->popup('Не указана целевая папка');
        }
        if (!$this->archiveFilePath) {
            response()->popup('Не указан путь к архивному файлу');
        }
    }

}