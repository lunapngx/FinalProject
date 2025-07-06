<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products'; // Your products table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // Or 'object' if you prefer objects
    protected $useSoftDeletes = false; // Set to true if you implement soft deletes

    // These fields must match the columns in your 'products' database table
    protected $allowedFields = [
        'name',
        'description',
        'price',
        'original_price', // Add if you have this column for sale prices
        'stock',
        'image',
        'category_id',
        'colors', // Assuming these are stored as JSON strings
        'sizes',  // Assuming these are stored as JSON strings
        // Add other product-related fields here, e.g., 'slug', 'status', 'created_at', 'updated_at'
    ];

    // Dates
    protected $useTimestamps = false; // Set to true if you have 'created_at', 'updated_at', 'deleted_at'
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}