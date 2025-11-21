<?php

namespace app\controller;

use app\formRequest\SearchRequest;
use app\repository\SearchRepository;
use JetBrains\PhpStorm\NoReturn;

class SearchController extends AppController
{
    private SearchRepository $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new SearchRepository();
    }

    #[NoReturn] public function actionIndex(SearchRequest $request): void
    {
        $req = $request->validated();
        $text = $this->service->index($req['text']);
        response()->json(['found' => $text]);
    }
}
