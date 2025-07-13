<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = true; // Kept as true from both sides

    // Combined allowed fields from both branches.
    // 'password_hash' is used here, assuming it's the correct column name for hashed passwords (as used in Auth.php).
    protected $allowedFields = [
        'username',
        'email',
        'password_hash', // Keeping this field as it matches usage in Auth.php
        'role',
        'status',
        'active',
        'fullname',
        'last_active',
        'created_at', // Included from HEAD
        'updated_at', // Included from HEAD
        'deleted_at'  // Included from HEAD
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation rules from HEAD, as remote had an empty array.
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username' => 'permit_empty|min_length[3]|is_unique[users.username,id,{id}]',
        'password_hash' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}