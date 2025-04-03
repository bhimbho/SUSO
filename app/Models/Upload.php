<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasUuids;

    protected $fillable = [
        'status',
        'llm_response',
        'user_id',
        'analysed_at',
    ];

    protected $casts = [
        'llm_response' => 'array',
        'analysed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uploadedImages()
    {
        return $this->hasMany(UploadedImage::class);
    }
}

