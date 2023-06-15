<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    //我们还需要前往路由的服务提供者类app/Providers/RouteServiceProvider.php中设置命名空间 → 否则会报错说找不到C控制器类，这是一次性的动作
    //同时要到下方的第40行后面插入这个namespace
    protected  $namespace =  'App\\Http\\Controllers'; 

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)   //这行就是要被插入的namespace （为何这里不用写分号呢，是因为这句并不是指令结束处吗）
                ->group(base_path('routes/web.php'));
        });
    }
}
