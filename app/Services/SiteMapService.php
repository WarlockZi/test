<?php

namespace app\Services;

class SiteMapService
{
    private array $hrefs = [];
    private array $disallows = [];
    private string $host = 'https://vitexopt.ru';

    public static function generateMap(): void
    {
        $self = new self();
        $self->getRobots();
        $url  = $self->host;
        $page = $self->getPage($url);

        $self->searchLinks($page);
        $self->cleanHrefs($self->hrefs);
    }

    private function getPage(string $url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $page = curl_exec($ch);
        curl_close($ch);
        return $page;
    }

    private function searchLinks(string $page, string $parent = ''): void
    {
        $pattern = "|<a.*(?=href=\"([^\"]*)\")[^>]*>([^<]*)</a>|i";
        $links   = preg_match_all($pattern, $page, $matches);
        $full    = $matches[0];
        if ($parent) {
            $this->hrefs[$parent] = $matches[1];
        } else {
            $this->hrefs = $matches[1];
        }
        $anchor = $matches[2];
    }

    private function cleanHrefs(array $hrefs): void
    {
        $exclude = ['/*?*'];
        foreach ($hrefs as $href) {
            foreach ($this->disallows as $disallow) {
                if (in_array($disallow, $exclude)) continue;
                $disallow = str_replace('*', '', $disallow);
                $disallow = substr($disallow, 1);
                if (preg_match("#{$disallow}#", $href, $matches)) {
                    $key = array_search($href, $this->hrefs);
                    unset($this->hrefs[$key]);
                }
            }
        }
        $this->process($this->hrefs);
    }

    private function process(array $hrefs): void
    {
        foreach ($hrefs as $href) {
            $url = "{$this->host}{$href}";
//            return;
            $page = $this->getPage($url);
            $hrefs = $this->searchLinks($page, $href);
            $this->cleanHrefs();
        }
        $f = 1;

    }

    public function excludeHrefs(): array
    {
        return [''];
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
        $full            = $matches[0];
        $this->disallows = $matches[1];
    }


//    private function write($xml): void
//    {
//        if (@simplexml_load_string($xml)) {
//            $fp = fopen('feed.xml', 'w');
//            fwrite($fp, $xml);
//            echo $xml;
//            fclose($fp);
//        }
//    }

//    private function addHrefs(): void
//    {
//        if (!$this->hrefs) {
//            $this->mapHrefs($this->hrefs);
////            $this->addHrefs();
//        } else {
//            foreach ($hrefs as $href) {
//                if (array_search($href, $this->hrefs) === false) {
//                    $this->addHrefs($href);
//                }
//            }
//        }
//    }

}