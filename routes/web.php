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
Route::get('/signup', 'UsersController@signup')->name('signup');    //@后面的方法原本写的create，我想在这次做教材的时候把方法名改成我直观理解的






