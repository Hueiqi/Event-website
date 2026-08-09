<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentationMaterial extends Model
{
    use HasFactory;

    protected $primaryKey = 'material_id';
    public $timestamps = false;

    protected $fillable = ['event_id', 'title', 'file_path', 'uploaded_by'];

    protected static function booted()
    {
        static::creating(function ($material) {
            $material->created_at = $material->created_at ?? now();
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'user_id');
    }
}
