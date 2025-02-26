<?php

namespace app\Services\XLService;

use app\model\CategoryProperty;
use Shuchkin\SimpleXLSX;

class XLService
{
    protected array $notFound;

    public function __construct()
    {
        $file = dirname(__FILE__) . '\TO_7267032.xlsx';
        $this->parseXLSX($file);
    }

    private function parseXLSX(string $file)
    {
        if ($xlsx = SimpleXLSX::parse($file)) {
            $i = 0;
            foreach ($xlsx->rows() as $row) {
                $i++;
                if ($i < 4) continue;
                $address = $row[0];
                $oldH1     = $row[2];
                $newH1     = $row[3];
                $this->findCategory($address, $newH1);
            }
        } else {
            echo SimpleXLSX::parseError();
        }
    }

    private function findCategory(string $address, string $newH1)
    {
        $path = parse_url($address)['path'];
        $arr  = explode('/', $path);
        $slug = array_pop($arr);
        $catProp = CategoryProperty::where('slug', $slug)->first();
        if ($catProp) {
            $catProp->seo_h1 = $newH1;
            $catProp->save();
        } else {
            $this->notFound[] = $catProp->slug;
        }
    }
}