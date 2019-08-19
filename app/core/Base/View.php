<?php

namespace app\core\Base;

class View {

    public $route;
    public $layout;
    public $view;
    public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];
    public static $JSCSS = ['js'=>[],'css'=>[]];

    function __construct($route, $layout = '', $view = '') {

        $this->route = $route;
        // Если в вид передали false то и в $this->layout устанавливаем false для отключения layout
        if ($layout === false) {
            $this->layout = false;
        } else {

            $this->layout = $layout ?: ''; //LAYOUT;
        }
        $this->view = $view;
    }

    public function render($vars) {

        if (is_array($vars)) {
            extract($vars);
        }
        $file_view = ROOT . "/app/view/{$this->route['controller']}/{$this->view}.php";
        // если режим отладки вкл, ставим метку и не кешируем

        ob_start();
        if (is_file($file_view)) {
            require $file_view;
        } else {
            echo "<br>Не найден файл вида {$this->view} ";
        }
        $content = ob_get_clean();

        ob_start();
        // Если в вид передали false то и в $this->layout устанавливаем false для отключения layout
        if ($this->layout !== FALSE) {
            $file_layout = ROOT . "/app/view/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                '<br> Не найден шаблон Layout' . $this->layout;
            }
        }
        $page_cache = ob_get_clean();
        echo $page_cache;
    }

    public static function setJSCSS($JSCSS) {
        self::$JSCSS['js'] = isset($JSCSS['js']) ?: array_merge(self::$JSCSS['js'], $JSCSS['js']);
        self::$JSCSS['css'] = isset($JSCSS['css']) ?: array_merge(self::$JSCSS['css'], $JSCSS['css']);
    }
    public static function getCSS() {
        foreach (self::$JSCSS['css'] as $v) {
            $include_css .= "<link href=" . $v . "?" . time() . " rel='stylesheet'>";
        }
        echo $include_css;
    }
    public static function getJS() {
        foreach (self::$JSCSS['js'] as $v) {
            $include_css .= "<link href=" . $v . "?" . time() . " rel='stylesheet'>";
        }
        echo $include_css;
    }
    /**
     * title - desc - keywords
     * */
    public static function setMeta($title = '', $desc = '', $keywords = '') {
        self::$meta['title'] = $title;
        self::$meta['desc'] = $desc;
        self::$meta['keywords'] = $keywords;
    }
    public static function getMeta() {
        echo '<title>' . self::$meta['title'] . '</title>
               <meta name = "description" content = "' . self::$meta['desc'] . '">
               <meta name = "keywords" content = "' . self::$meta['keywords'] . '">';
    }


    public static function e($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
    }

}
