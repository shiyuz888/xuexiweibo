<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function signup()
    {
        return view('users.signup');    //方法名原本是create，我想直观点，所以改成了signup 跟路由里相同。另外视图页面也改成了signup这个连接地址名
    }
}
