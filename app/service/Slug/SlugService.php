<?php


namespace app\service\Slug;


use app\model\Category;
use app\model\Product;

class SlugService
{
    private $char_map = array(
        // Russian
        "А" => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',

    );

    public static function getValidProductSlug(Product $product): string
    {
        $slug = SlugService::slug($product['print_name']);
        if (Product::where('slug', $slug)->first()) {
            $art  = SlugService::slug($product['art']);
            $slug = "$slug" . "_" . "$art";
            $i    = 0;
            while (Product::where('slug', $slug)->first()) {
                $slug = "$slug" . "_" . "$i++";
            }
        }
        return $slug;
    }

    public static function getCategorySlug(Category $category): string
    {
        $slug = SlugService::slug($category['name']);
        if (Category::where('slug', $slug)->first()) {
            while (Category::where('slug', $slug)->first()) {
                $slug = "{$slug}_0";
                $i    = 0;
                $slug = "$slug" . "_" . "++$i";
            }
        }
        return $slug;
    }

    public static function slug($str, $options = array()): string
    {
        $self = new self();

        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'substituteSpaceBy' => '_',
            'limit' => null,
            'lowercase' => true,
            'replacements' => $self->char_map,
            'transliterate' => false,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        );

        $value = mb_strtolower($str);
        $value = strtr($value, $converter);
        $value = mb_ereg_replace('\s', '_', $value);
        $value = mb_ereg_replace('[^-0-9a-z_]', $defaults['substituteSpaceBy'], $value);
        $value = mb_ereg_replace('[-]+', '-', $value);
        $value = trim($value, '-');
//		sometimes slugs differ by dot at the end replaced by underscore
//		$value = trim($value, '_');

        return $value;
    }

    public static function getSubslugs(string $slug, int $count = 4): array
    {
        $percent    = [0.33, 0.25, 0.20, 0.20];
        $charsCount = mb_strlen($slug);
        $subslugs   = array();
        for ($i = 1; $i < $count ; ++$i) {
            $minus    = (int)ceil($charsCount * $percent[$i])*(-1);
            $newSlug = substr($slug, 0, $minus);
            $subslugs[] = $newSlug;
            $slug = $newSlug;
        }
        return $subslugs;

    }
    public static function categoryLastSegment(string $slug): string
    {
        $segments = explode('/', $slug);
        return $segments[count($segments)-1];
    }
}



