<?php

namespace App\Models; // This must be correct

use CodeIgniter\Model;

class OrderModel extends Model // This must match the filename and namespace
{
    protected $table      = 'orders'; // Ensure your orders table name is correct
    protected $primaryKey = 'id';
    // ... (other model properties like $allowedFields, $useTimestamps, etc.)
}