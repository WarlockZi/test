<?php

namespace app\controller\Admin;

use app\controller\Controller;
use app\service\SitemapService\SiteMapService;

class SitemapController extends Controller
{
    public function __construct(
        protected SiteMapService $service = new SiteMapService(),
    )
    {

    }

    public function actionIndex(): void
    {
        $this->service::generateMap();

    }


}


