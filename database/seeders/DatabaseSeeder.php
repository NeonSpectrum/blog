<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
                     ['username' => 'user', 'name' => 'User', 'password' => '1234', 'user_type' => 'user'],
                     ['username' => 'admin', 'name' => 'Admin', 'password' => '12345', 'user_type' => 'admin'],
                 ] as $user) {
            $model = new User($user);
            $model->save();
        }

        foreach ([
                     ['name' => 'Creativity'],
                     ['name' => 'Food'],
                     ['name' => 'Travel'],
                     ['name' => 'Humor'],
                     ['name' => 'Music'],
                 ] as $category) {
            $model = new Category($category);
            $model->save();
        }
    }
}
