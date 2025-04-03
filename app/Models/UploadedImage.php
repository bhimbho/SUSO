<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UploadedImage extends Model
{
    use HasUuids;
    
    protected $fillable = ['upload_id', 'path'];

    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }
}
