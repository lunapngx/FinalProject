<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder; // Ensure this is imported

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the CodeIgniter Shield AuthSeeder
        $this->call('CodeIgniter\Shield\Database\Seeds\AuthSeeder');

        // You can add calls to your own application seeders here later, e.g.:
        // $this->call('UserSeeder');
        // $this->call('ProductSeeder');
        // $this->call('CategorySeeder');
    }
}