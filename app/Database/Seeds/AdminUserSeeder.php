<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();

        $data = [
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => password_hash('adminpassword', PASSWORD_DEFAULT), // This should match the field in allowedFields
            'role'     => 'admin',
            'fullname' => 'Administrator',
            'active'   => 1,
            'status'   => 'active',
        ];

        $existingAdmin = $model->where('email', $data['email'])->first();

        if (!$existingAdmin) {
            $model->save($data);
            echo "Admin user created successfully.\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}