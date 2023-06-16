<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //9.2节账户激活，先做数据表active字段，然后到这里来做监听
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];






    

    // 在用户模型中定义一个 gravatar 方法，用来生成用户的头像
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "https://sdn.geekzu.org/avatar/$hash?s=$size";
    }

        

    //微博
    public function microblogs()
    {
        return $this->hasMany(Microblog::class);
    }


    public function feed()
    {
        /*优化前的feed流，只能在首页显示自己发的微博列表
        return $this->microblogs()
                    ->orderBy('created_at', 'desc');
        */

        //优化后可以显示自己以及自己关注的人的微博，并按时间降序排列
        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids, $this->id);
        return Microblog::whereIn('user_id', $user_ids)
                              ->with('user')
                              ->orderBy('created_at', 'desc');
    }



    //关注、被关注
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function follow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    public function unfollow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }

}
