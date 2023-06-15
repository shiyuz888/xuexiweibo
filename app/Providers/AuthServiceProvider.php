<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //教材8.3权限系统 → 用户只能修改自己的资料的policy做好之后，要到这里来添加下方：自动注册授权策略

        $this->registerPolicies();
        // 修改策略自动发现的逻辑
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            // 动态返回模型对应的策略名称，如：// 'App\Models\User' => 'App\Policies\UserPolicy',
            return 'App\Policies\\'.class_basename($modelClass).'Policy';
        });
    }
}
