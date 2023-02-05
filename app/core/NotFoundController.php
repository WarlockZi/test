<?php


namespace app\core;


use app\controller\Controller;

class NotFoundController extends Controller
{
  public function __construct($route)
  {
    parent::__construct($route);
  }

}