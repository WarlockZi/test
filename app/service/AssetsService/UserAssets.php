<?php


namespace app\service\AssetsService;


class UserAssets
{

    public function __construct(
    )
    {
        parent::__construct();
        $this->setCss('chatLocalStorage');
        return $this;
    }

    public function setQuill(): void
    {
//		$this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.bubble.css");
        $this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.js");
        $this->setCDNCss("https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css");
    }

}