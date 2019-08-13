<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //... DB::table('admins')->insert([
       //     'username' => Str::random(10),
       //     'email' => Str::random(10).'@gmail.com',
        //    'password' => bcrypt('secret'),
       //     'number'=>'01679244991'
       // ]);
         factory(App\Admin::class, 100)->create();
    }
}
