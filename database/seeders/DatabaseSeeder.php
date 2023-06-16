<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//教材8.4节还要加上下面这个Eloquent模型
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(MicroblogsTableSeeder::class);
        $this->call(FollowersTableSeeder::class);

        Model::reguard();
        
    }
}
