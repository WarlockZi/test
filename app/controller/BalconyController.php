<?php

namespace app\controller;


use app\controller\Admin\AdminscController;

class BalconyController extends AdminscController
{
    public function __construct()
    {
        parent::__construct();
    }

	public function actionIndex(): void
    {
        $conf = [
            'company'=>'Балконная дверь',
            'city'=>'Вологда',

            'email'=>'vvoronik@yandex.ru',

            'phone'=>'+79217152464',

            'tg_href'=>"https://t.me/vitex",

            'work_from'=>'9:00',
            'work_to'=>'19:00'
        ];
        $data=[
            'email_href'=>"mailto:{$conf['email']}",
            'phone_href'=>"tel:{$conf['phone']}",

            'js'=>'/public/src/balcony/js/',
            'css'=>'/public/src/balcony/css/',
            'images'=>'/public/src/balcony/images/',
            'slider'=>'/public/src/balcony/images/slider/',

            'seo_keywords'=>"Компания «{$conf['company']}», балконы и лоджии ремонт под ключ",
            'seo_description'=>"Компания «{$conf['company']}» занимается оборудованием балконов и лоджий в Вологде! Компания предоставляет сервисные услуги по ремонту и обустройству балкново и лоджий в квартирах и частных домах под ключ: тел.{$conf['phone']}.",
            'seo_title'=>"Балконы и лоджии цены под ключ в Вологде | «{$conf['company']}»",

        ];
        view('admin.balcony.index',compact('data', 'conf'));
	}

}
