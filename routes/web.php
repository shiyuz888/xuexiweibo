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


Route::resource('users', 'UsersController');
/*上面这行等价于下面
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::post('/users', 'UsersController@store')->name('users.store');


Route::get('/users', 'UsersController@index')->name('users.index');
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
*/


//因为指定的路径一样，比如都是/login，所以name就一样了，只是在同一个URL路径对应的控制器里用了两种函数，分别对应的是显示页面和实现提交功能
//但是也可以是不同的name指向同一个URL，你看上面的index方法和store方法，为什么他们是指向同一个URL的呢？
// 控制器内的方法函数名被我修改了
Route::get('/login', 'SessionsController@login_page')->name('login');
Route::post('/login', 'SessionsController@login_verify')->name('login');
Route::delete('/logout', 'SessionsController@user_logout')->name('logout');

