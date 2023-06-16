<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//下面两行教材10.5节 首页显示微博列表 添加
use App\Models\Microblog;
use Illuminate\Support\Facades\Auth;


class StaticPagesController extends Controller
{
    public function home () {


        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(5);
        }


        return view('static_pages/home', compact('feed_items'));
    }




    public function help () {
        return view('static_pages/help');
    }

    public function about () {
        return view('static_pages/about');
    }


}
