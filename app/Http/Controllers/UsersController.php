<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// 要写use哪个模型
use App\Models\User;

// 教材7.3节用户登录添加下行。目的是让用户注册后能够直接自动登录。看store方法里多了个auth
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function signup()
    {
        return view('users.signup');    //方法名原本是create，我想直观点，所以改成了signup 跟路由里相同。另外视图页面也改成了signup这个连接地址名
    }



    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }




    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }











}
