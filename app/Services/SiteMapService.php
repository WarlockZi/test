<?php

namespace app\Services;

class SiteMapService
{

    public static function generateMap()
    {
        $self = new self();
        $url  = 'https://vitexopt.ru';
        $ch   = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $page = curl_exec($ch);
        curl_close($ch);

        $links = $self->searchLinks($page);
    }

    private function searchLinks(string $page): array
    {
        $pattern = "|<a.*(?=href=\"([^\"]*)\")[^>]*>([^<]*)</a>|i";
        $links   = preg_match_all($pattern, $page, $matches);
        $full    = $matches[0];
        $href    = $matches[1];
        $anchor  = $matches[2];
        $this->addHrefs($href);

    }
                    private function write($xml)

    {
        if (@simplexml_load_string($xml)) {
            $fp = fopen('feed.xml', 'w');
            fwrite($fp, $xml);
            echo $xml;
            fclose($fp);
        }
    }

    private function addHrefs(array $hrefs): void
    {
        if (!$this->hrefs) {
            array_merge($this->hrefs, $hrefs);
        } else {
            foreach ($hrefs as $href) {
                if (array_search($href, $this->hrefs) === false) {
                    $this->addHrefs($href);
                }
            }
        }

    }

    public function excludeHrefs(): array
    {
        return [
            ''
        ];
    }

    private function getRobots(): void
    {
        $url = 'https://vitexopt.ru/robots.txt';
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $page = curl_exec($ch);
        curl_close($ch);

        $this->parceRobots($page);
    }

    public function parceRobots(string $page): void
    {
        $pattern = "|^\s*Disallow:\s(.*)\s|mi";
        preg_match_all($pattern, $page, $matches);
        $full               = $matches[0];
        $this->excludeHrefs = $matches[1];
    }
}