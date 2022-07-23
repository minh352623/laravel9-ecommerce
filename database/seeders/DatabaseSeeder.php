<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // DB::statement('SET FOREIGN_KEY_CHECKS=0'); //cho phép khóa ngoại nhập số 0 vào.
        // $groupsId = DB::table('groups')->insertGetId([
        //     'name' => 'Administrator',
        //     'user_id' => 0,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s')

        // ]);
        // DB::statement('SET FOREIGN_KEY_CHECKS=1'); //sau khi chạy xong thì gán là 1


        // if ($groupsId > 0) {
        //     $userID = DB::table('users')->insertGetId([
        //         'name' => 'Công Minh',
        //         'email' => 'congminh352623@gmail.com',
        //         'password' => Hash::make('123456'),
        //         'group_id' => $groupsId,
        //         'user_id' => 0,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s')
        //     ]);
        //     if ($userID > 0) {
        //         for ($i = 0; $i <= 5; $i++) {
        //             DB::table('posts')->insert([
        //                 'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
        //                 'content' => 'Ab, amet doloremque! Totam quis laudantium illum corporis, mollitia ipsam nihil provident fugiat dignissimos pariatur dicta. Nihil totam accusamus distinctio at corporis.',
        //                 'user_id' => $userID,
        //                 'created_at' => date('Y-m-d H:i:s'),
        //                 'updated_at' => date('Y-m-d H:i:s')
        //             ]);
        //         }
        //     }
        // }


        // DB::table('modules')->insert([
        //     'name' => 'users',
        //     'title' => 'Quản lí người dùng',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),

        // ]);
        // DB::table('modules')->insert([
        //     'name' => 'groups',
        //     'title' => 'Quản lí nhóm người dùng',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),

        // ]);
        // DB::table('modules')->insert([
        //     'name' => 'posts',
        //     'title' => 'Quản lí bài viết',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),

        // ]);
        DB::table('modules')->insert([
            'name' => 'menus',
            'title' => 'Menu',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);
        DB::table('modules')->insert([
            'name' => 'categories',
            'title' => 'Danh mục sản phẩm',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);
        DB::table('modules')->insert([
            'name' => 'products',
            'title' => 'Sản phẩm',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);
        DB::table('modules')->insert([
            'name' => 'settings',
            'title' => 'Cài đặt',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);
        DB::table('modules')->insert([
            'name' => 'sliders',
            'title' => 'Slider',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);
    }
}
