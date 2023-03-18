<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $allBooks = ['b1', 'b2'];

        return view('test', ['books' => $allBooks]);
    }
}