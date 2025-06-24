<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DugaController extends Controller
{
    public function index()
    {
        return view('duga.index'); // 'duga' ディレクトリ内の 'index' ビューを指します
    }
}