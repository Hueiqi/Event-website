<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    public $timestamps = false;

    protected $fillable = ['category_name', 'description'];

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->created_at = $category->created_at ?? now();
        });
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'category_id', 'category_id');
    }
}
