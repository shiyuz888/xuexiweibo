<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// 要写use哪个模型
use App\Models\User;

// 教材7.3节用户登录添加下行。目的是让用户注册后能够直接自动登录。看store方法里多了个auth
use Illuminate\Support\Facades\Auth;

//教材9.2节账户激活 要这个来发送注册激活码邮件
use Illuminate\Support\Facades\Mail;


class UsersController extends Controller
{

    //8.3节权限系统 必须先登录
    public function __construct()
    {
        $this->middleware('auth', [            
            'except' => ['show', 'signup', 'store', 'index', 'confirm_email']     //必须先登录才能用所有功能，除非show个人中心、新注册、注册提交
        ]);


        //8.3节 只让未登录的用户访问注册页面
        $this->middleware('guest', [
            'only' => ['signup']    //这里原本教材是create以及上面第22行也是create，不过我因为不想用create，教材里的命名挺容易让新人混淆的，所以我改成了signup
        ]);


        // 限流 一个小时内只能提交 10 次请求；————这个地方我有担心说是不是限制同一个IP，如果不是限制同一个IP那不符合常理吧？
        $this->middleware('throttle:10,60', [
            'only' => ['store']
        ]);

    }



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

        // Auth::login($user);
        // session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        // return redirect()->route('users.show', [$user]);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
    }

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'confirm_email.signup_activation';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    public function confirm_email($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }




    public function edit(User $user)
    {
        $this->authorize('update', $user);  //edit和update方法使用一致的策略：在UserPolicy中定义的用户只能修改自己的资料
        return view('users.edit', compact('user'));
    }


    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);  //edit和update方法使用一致的策略：在UserPolicy中定义的用户只能修改自己的资料
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }



    public function index()
    {
        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }


    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }


}
