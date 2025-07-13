<?php namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders'; // Replace 'orders' with your actual table name
    protected $primaryKey = 'id'; // Replace 'id' with your actual primary key

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // or 'object'
    protected $useSoftDeletes = false;

    protected $allowedFields = ['column1', 'column2', /* ... other columns */]; // Add your table columns here

    // If you have timestamps
    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation rules (optional)
    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;
}