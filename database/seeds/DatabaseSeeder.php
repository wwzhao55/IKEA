<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        DB::table('admin')->insert([
            'account' => 'admin',
            'password' => md5('123456'),
            'status'=>1,
            'created_at'=>time(),
            'updated_at'=>time(),
        ]);
    }
}
