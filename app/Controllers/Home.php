<?php

namespace App\Controllers;

class Home extends BaseController
{
  public function index(): string
  {
    return $this->render('welcome_message');
  }
}
