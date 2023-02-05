<?php


namespace app\core;


use app\controller\AppController;
use app\controller\Controller;

class NotFoundController extends AppController
{
  public function __construct($route)
  {
    parent::__construct($route);
  }



}