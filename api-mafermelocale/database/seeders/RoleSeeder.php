<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        $roles_list = [
            ['name' => 'Agriculteur', 'lang_id' => '1'],
            ['name' => 'Utilisateur', 'lang_id' => '1']
        ];

        foreach ($roles_list as $value) {
            Role::create($value);
        }
    }
}
