<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    // The table associated with this model.
    protected $table      = 'products';
    // The primary key field for the table.
    protected $primaryKey = 'id';

    // Whether to use auto-incrementing for the primary key.
    protected $useAutoIncrement = true;

    // The type of data to return (e.g., 'array' or 'object').
    protected $returnType     = 'array';
    // Whether to use soft deletes (marking records as deleted instead of truly removing them).
    protected $useSoftDeletes = false; // Set to true if you implement soft deletes and have a 'deleted_at' column

    // List of fields that can be mass-assigned.
    // These fields must match the columns in your 'products' database table.
    protected $allowedFields = [
        'name',
        'description',
        'price',
        'original_price', // Add if you have this column for sale prices
        'stock',
        'image',
        'category_id',
        'colors', // Stored as JSON strings in the database
        'sizes',  // Stored as JSON strings in the database
        // Add other product-related fields here, e.g., 'slug', 'status'
    ];

    // Dates
    // Whether to use timestamps for created_at, updated_at, and deleted_at fields.
    protected $useTimestamps = true; // Set to true to automatically manage created_at and updated_at
    // The format for date fields.
    protected $dateFormat    = 'datetime';
    // The database column for creation timestamp.
    protected $createdField  = 'created_at';
    // The database column for update timestamp.
    protected $updatedField  = 'updated_at';
    // The database column for deletion timestamp (only if useSoftDeletes is true).
    protected $deletedField  = 'deleted_at';

    // Validation Rules
    protected $validationRules = [
        'name'        => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|max_length[5000]',
        'price'       => 'required|numeric|greater_than[0]',
        'original_price' => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[price]', // Validation for original_price
        'stock'       => 'required|integer|greater_than_equal_to[0]',
        'category_id' => 'required|integer', // Removed 'is_valid_category_id' for simplicity, you can re-add if custom rule is implemented
        'image'       => 'permit_empty|mime_in[image,image/jpg,image/jpeg,image/png,image/gif]|max_size[image,1024]', // Image is optional on update, required on create handled by controller
        'colors'      => 'permit_empty', // Validation for JSON conversion handled by callback
        'sizes'       => 'permit_empty',  // Validation for JSON conversion handled by callback
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Product name is required.',
            'min_length' => 'Product name must be at least 3 characters long.',
            'max_length' => 'Product name cannot exceed 255 characters.',
        ],
        'price' => [
            'required' => 'Price is required.',
            'numeric' => 'Price must be a number.',
            'greater_than' => 'Price must be greater than 0.',
        ],
        'original_price' => [
            'numeric' => 'Original price must be a number.',
            'greater_than_equal_to' => 'Original price must be 0 or greater.',
            'less_than_equal_to' => 'Original price cannot be greater than the current price.',
        ],
        'stock' => [
            'required' => 'Stock quantity is required.',
            'integer' => 'Stock must be an integer.',
            'greater_than_equal_to' => 'Stock cannot be negative.',
        ],
        'category_id' => [
            'required' => 'Category is required.',
            'integer' => 'Invalid category ID.',
            // 'is_valid_category_id' => 'Selected category is not valid.', // Message for custom rule if re-added
        ],
        'image' => [
            'uploaded' => 'Product image is required.', // This message is for when 'uploaded' rule is used
            'max_size' => 'Image file is too large (max 1MB).',
            'is_image' => 'Uploaded file is not a valid image.',
            'mime_in'  => 'Only JPG, JPEG, PNG, GIF images are allowed.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    // Callbacks are methods that are run before or after certain database events.
    protected $allowCallbacks = true;
    // 'beforeInsert' and 'beforeUpdate' will call 'encodeJsonFields' to convert arrays to JSON strings,
    // and 'setTimestamps' to manage 'created_at'/'updated_at'.
    protected $beforeInsert   = ['encodeJsonFields', 'setTimestamps'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['encodeJsonFields', 'setTimestamps'];
    protected $afterUpdate    = [];
    // 'afterFind' will call 'decodeJsonFields' to convert JSON strings back to arrays.
    protected $beforeFind     = [];
    protected $afterFind      = ['decodeJsonFields'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Callback method to set 'created_at' and 'updated_at' timestamps.
     * Automatically called before insert and update operations.
     *
     * @param array $data The data array being inserted or updated.
     * @return array The modified data array.
     */
    protected function setTimestamps(array $data)
    {
        // Set 'created_at' only if it's a new record (not already set)
        $data['data']['created_at'] = $data['data']['created_at'] ?? date('Y-m-d H:i:s');
        // Always update 'updated_at' on insert and update
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    /**
     * Callback method to decode JSON strings in 'colors' and 'sizes' fields into PHP arrays.
     * Automatically called after data is retrieved from the database.
     *
     * @param array $data The data array retrieved from the database.
     * @return array The modified data array with decoded JSON fields.
     */
    protected function decodeJsonFields(array $data)
    {
        // Check if 'colors' exists and is a string, then decode it
        if (isset($data['data']['colors']) && is_string($data['data']['colors'])) {
            $data['data']['colors'] = json_decode($data['data']['colors'], true);
            // If decoding fails, set to empty array to prevent errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                $data['data']['colors'] = [];
            }
        } else if (!isset($data['data']['colors']) || $data['data']['colors'] === null) {
            // Ensure 'colors' is always an array, even if null or not set
            $data['data']['colors'] = [];
        }

        // Check if 'sizes' exists and is a string, then decode it
        if (isset($data['data']['sizes']) && is_string($data['data']['sizes'])) {
            $data['data']['sizes'] = json_decode($data['data']['sizes'], true);
            // If decoding fails, set to empty array to prevent errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                $data['data']['sizes'] = [];
            }
        } else if (!isset($data['data']['sizes']) || $data['data']['sizes'] === null) {
            // Ensure 'sizes' is always an array, even if null or not set
            $data['data']['sizes'] = [];
        }

        return $data;
    }

    /**
     * Callback method to encode PHP arrays in 'colors' and 'sizes' fields into JSON strings.
     * Automatically called before insert and update operations.
     *
     * @param array $data The data array being inserted or updated.
     * @return array The modified data array with encoded JSON fields.
     */
    protected function encodeJsonFields(array $data)
    {
        // If 'colors' exists and is an array, encode it to JSON
        if (isset($data['data']['colors']) && is_array($data['data']['colors'])) {
            $data['data']['colors'] = json_encode($data['data']['colors']);
        } else if (isset($data['data']['colors']) && is_string($data['data']['colors'])) {
            // If it's a string (e.g., from old() or direct input), convert comma-separated to array then to JSON
            $data['data']['colors'] = json_encode(array_map('trim', explode(',', $data['data']['colors'])));
        } else {
            // Ensure it's stored as an empty JSON array if not provided or invalid
            $data['data']['colors'] = json_encode([]);
        }

        // If 'sizes' exists and is an array, encode it to JSON
        if (isset($data['data']['sizes']) && is_array($data['data']['sizes'])) {
            $data['data']['sizes'] = json_encode($data['data']['sizes']);
        } else if (isset($data['data']['sizes']) && is_string($data['data']['sizes'])) {
            // If it's a string (e.g., from old() or direct input), convert comma-separated to array then to JSON
            $data['data']['sizes'] = json_encode(array_map('trim', explode(',', $data['data']['sizes'])));
        } else {
            // Ensure it's stored as an empty JSON array if not provided or invalid
            $data['data']['sizes'] = json_encode([]);
        }

        return $data;
    }
}
