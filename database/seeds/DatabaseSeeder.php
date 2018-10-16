<?php

use Illuminate\Database\Seeder;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
      $role_creator = new Role();
      $role_creator->name = 'creator';
      $role_creator->save();

      $role_user = new Role();
      $role_user->name = 'user';
      $role_user->save();
    }
}
