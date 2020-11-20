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
        $user = new User();
        $user->name = 'Mychi';
        $user->email = "mickdd22@gmail.com";
        $user->password = md5("password.demo");
        $user->save();
    }
}
