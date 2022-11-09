<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'roles_id' => '1',
            'name' => 'perusahaan',
            'email' => 'perusahaan@gmail.com',
            'password' =>Hash::make('adminadmin') ,
            
        ]);
        DB::table('users')->insert([
            'roles_id' => '1',
            'name' => 'amir',
            'email' => 'amir@gmail.com',
            'password' =>Hash::make('adminadmin') ,
            
        ]);
        DB::table('users')->insert([
            'roles_id' => '2',
            'name' => 'bobi',
            'email' => 'bobi@gmail.com',
            'password' =>Hash::make('adminadmin') ,
            
        ]);
        DB::table('users')->insert([
            'roles_id' => '2',
            'name' => 'coki',
            'email' => 'coki@gmail.com',
            'password' =>Hash::make('adminadmin') ,
            
        ]);
    }
}
