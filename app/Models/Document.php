<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    protected $fillable = [
        'documentable_type',
        'documentable_id',
        'collection',
        'filename',
        'path',
        'disk',
        'mime_type',
        'size'
    ];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
