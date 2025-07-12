<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model // Corrected class name to AdminModel
{
    protected $table      = 'users'; // Admins are typically stored in the 'users' table
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false; // Set to true if you use soft deletes for users

    protected $allowedFields = [
        'username',
        'email',
        'password', // Ensure this matches your column for password hash
        'role',     // Essential for distinguishing admin users
        'status',
        'active',
        'fullname',
        'last_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation (add rules as needed for admin user specific fields)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Retrieves all users with the 'admin' role.
     */
    public function getAdminUsers()
    {
        return $this->where('role', 'admin')->findAll();
    }
}