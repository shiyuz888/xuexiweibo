<?php

use Illuminate\Support\Facades\Route;


/*初始默认↓
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/suibianxie', function () {
    return view('copy-welcome');
});
/*
上面→ 在主域名后面键入suibianxie就可以到达copy-welcome视图页面，即xuexiweibo.xyz/suibianxie
所以URL的字符串并不需要跟视图页面的文件名相一致
另外，如果你把视图文件命名为copy.welcome.blade.php，则laravel会找不到这个页面，报错不存在这个页面
所以命名视图页面的时候在blade.php前面不要有多余的点“.” → 就用上述的划线、下划线、其他字母等代替就可以了
*/


// get、post等四个方法 → URL字符串，不需要跟相关的视图文件名一致 → 控制器名@控制器内的方法函数名 
// → 起个代号【代号可以用在视图页面作为href超链接，格式为{{ route ( '代号名 ' ) }}  这个代号可以不变，此时get等方法指向的URL字符串就可以在需要的时候随意更改连接地址
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');


//教材4.7节 正式开始做用户注册页面 以及连带的控制器、模型等功能
Route::get('/signup', 'UsersController@signup')->name('signup');    
//@后面的方法原本写的create，我想在这次做教材的时候把方法名改成我直观理解的。页面中出现{{ route('name') }}其实就是根据name获得URL路径，同时去找对应的控制器里的那个@函数
Route::get('/signup/confirm/{token}', 'UsersController@confirm_email')->name('confirm_email');
// ↑↑这是教材9.2节激活账户，用来发送激活码邮件



Route::resource('users', 'UsersController');
/*上面这行等价于下面
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::post('/users', 'UsersController@store')->name('users.store');

Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
Route::get('/users', 'UsersController@index')->name('users.index');

Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
Route::get('/users/create', 'UsersController@create')->name('users.create');    //这个没用到，我感觉这个就是signup，你如果不写signup就直接用这个create就好了
*/


//因为指定的路径一样，比如都是/login，所以name就一样了，只是在同一个URL路径对应的控制器里用了两种函数，分别对应的是显示页面和实现提交功能
//但是也可以是不同的name指向同一个URL，你看上面的index方法和store方法，为什么他们是指向同一个URL的呢？
// 控制器内的方法函数名被我修改了
Route::get('/login', 'SessionsController@login_page')->name('login');
Route::post('/login', 'SessionsController@login_verify')->name('login');
Route::delete('/logout', 'SessionsController@user_logout')->name('logout');



//密码重置第一步：点击忘记密码超链接后，会去到 请求重置密码的页面（该页面是要你填写你的注册邮箱，填写好之后要点击“重置”按钮让网站来发送验证身份的邮件给你，此时网站会校验这个邮箱是否注册过，通过校验的话邮件会发送）
Route::get('/password-reset-request',  'PasswordController@password_reset_request')->name('password_reset_request');
// 密码重置第二步：控制器要完成发送邮件的动作
Route::post('/password-reset-email',  'PasswordController@password_reset_email')->name('password_reset_email');
// 密码重置第三步：对方把邮件中的验证码输入回浏览器之后，通过校验就要跳到重置密码的页面，此时用户输入自己重置的密码
Route::get('/password-reset/{token}',  'PasswordController@password_reset_token')->name('password_reset_token');
// 密码重置第四步：用户提交重置的密码时，控制器要完成这个重置的动作
Route::post('/password-reset',  'PasswordController@password_reset')->name('password_reset');

