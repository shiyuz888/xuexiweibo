<?php

namespace App\Policies;

use App\Models\User;


//教材8.3权限系统 →用户只能编辑自己的资料
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    //教材8.3 用户只能编辑自己的资料 的代码逻辑
    use HandlesAuthorization;

    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    
    //教材8.6删除用户 的策略
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }


    
    //教材11.5关注按钮 用户不能关注自己
    public function follow(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }
}
