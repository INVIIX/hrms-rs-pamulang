<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

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

    public function urlStream(): Attribute
    {

        return Attribute::make(
            get: fn(mixed $value, array $attributes) => url()->query('/api/file', [
                'path' => $attributes['path'],
            ]),
        );
    }

    protected function urlDownload(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => url()->query('/api/file', [
                'path' => $attributes['path'],
                'download' => true
            ]),
        );
    }
}
