<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'products';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'name',
        'price', 
        'category_id',
        'status_id',
    ];

     /**
     * Foreign Key
     *
     * Relationship
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
    public function status()
    {
        return $this->belongsTo(\App\Models\Status::class, 'status_id');
    }
}
