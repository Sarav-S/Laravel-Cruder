<?php

namespace Code\Admin\database\seeds;

use Code\Admin\Model\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
        	'name'     => 'Admin',
        	'email'    => 'me@sarav.co',
        	'password' => bcrypt('admin123')
        ]);
    }
}
