<?php
namespace App\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = new User();
        // $user->name = 'Mychi';
        // $user->email = "mickdd22@gmail.com";
        // $user->password = md5("password.demo");
        // $user->save();

        // factory(App\User::class, 50)->create()->each(function ($user) {
        //     $user->posts()->save(factory(App\Post::class)->make());
        // });

        User::factory()->times(50)->create();
    }
}
