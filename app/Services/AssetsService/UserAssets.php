<?php


namespace app\Services\AssetsService;


class UserAssets extends Assets
{

    public function __construct()
    {
        parent::__construct();
        $this->setJs('main');
//		$this->setJs('chatLocalStorage');

        $this->setCss('main');
        $this->setCss('chatLocalStorage');

        return $this;
    }

    public function setQuill(): void
    {
//		$this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.bubble.css");
        $this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.js");
        $this->setCDNCss("https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css");
    }

    public function setAuth(): void
    {
        $this->setJs('auth');
        $this->setCss('auth');
    }
}