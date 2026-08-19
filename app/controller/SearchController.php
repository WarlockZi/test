<?php

namespace app\controller;

use app\formRequest\SearchRequest;
use app\repository\SearchRepository;
use JetBrains\PhpStorm\NoReturn;

class SearchController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(SearchRequest $request, SearchRepository $repo): void
    {
        $text = $request->validated()['text']??'';
        $productsArr = $repo->searchProducts($text);
        response()->json(['found' => $productsArr]);
    }
}
