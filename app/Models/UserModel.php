<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users'; // Your users table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // Or 'object' if you prefer objects
    protected $useSoftDeletes = false; // Set to true if you implement soft deletes

    // These fields must match the columns in your 'users' database table
    protected $allowedFields = [
        'email',
        'password_hash',
        // Add any other user-related fields here, like 'username', 'first_name', 'last_name', etc.
        // For Shield users, 'username' might be managed differently.
    ];

    // Dates
    protected $useTimestamps = true; // Assuming your users table has created_at and updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // If you use soft deletes

    // Validation (add rules as needed for user registration/updates)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}