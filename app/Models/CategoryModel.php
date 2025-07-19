<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];

    protected $returnType     = 'array'; // Or 'object'
    protected $useSoftDeletes = false; // Set to true if you use soft deletes

    // These fields must match the columns in your 'categories' database table
    // Dates
    protected $useTimestamps = false; // Set to true if you have 'created_at', 'updated_at', etc.
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}