<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class CategoryController extends Controller
{
    public function categoryList()
    {
        return \App\view('partials.category-list');
    }
}