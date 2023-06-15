<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//教材7.2节会话 需要添加下行。注意教材7.4节退出也需要这个auth，你看下user_logout方法里有auth
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{

    //8.3节权限系统中 只让未登录用户访问登录页面
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['login_page']    //教材这里写的是create，我因为不像跟UsersController里的create重复混淆，所以改了，看看会不会报错
        ]);

        // 限流 10 分钟十次
        $this->middleware('throttle:10,10', [
            'only' => ['login_verify']
        ]);

    }


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
            if(Auth::user()->activated) {   //9.2节嵌套了账户激活与否的判断
                session()->flash('success', '欢迎回来！');

                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            // 上面两行是教材8.3节权限系统友好的重定向→如果当一个已注册但未登录的用户尝试访问自己的资料编辑页面时，将会自动跳转到登录页面，这时候如果用户再进行登录，则会重定向到其个人中心页面上，这种方式的用户体验并不好。更好的做法是，将用户重定向到他之前尝试访问的页面，即自己的个人编辑页面。redirect() 实例提供了一个 intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。
            // 但是!逻辑上很奇怪：他既然没有登录，那么也就不会有userid/edit的URL链接。除非他之前就把这个链接收藏了。。。
            // 下面一行是原本的return
            // return redirect()->route('users.show', [Auth::user()]);

            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
        } else {    
            // 登录失败后的相关操作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }

    }


    public function user_logout()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }


}
