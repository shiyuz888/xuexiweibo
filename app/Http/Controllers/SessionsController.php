<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//教材7.2节会话 需要添加下行。注意教材7.4节退出也需要这个auth，你看下user_logout方法里有auth
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function login_page()
    {
        return view('sessions.login');
    }


    public function login_verify(Request $request)
    {
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

       if (Auth::attempt($credentials, $request->has('remember'))) {    //这里的remember是在添加了记住我复选框后 添加出来的 --它跟login视图里的复选框名字remember关联
            // 登录成功后的相关操作
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            // 登录失败后的相关操作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }

    return;

    }


    public function user_logout()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }


}
