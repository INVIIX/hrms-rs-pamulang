<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceIndicator extends Model
{
    protected $fillable = ['employee_id', 'year', 'attachment'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function urlStream(): Attribute
    {

        return Attribute::make(
            get: fn(mixed $value, array $attributes) => url()->query('/api/file', [
                'path' => $attributes['attachment'],
            ]),
        );
    }

    protected function urlDownload(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => url()->query('/api/file', [
                'path' => $attributes['attachment'],
                'download' => true
            ]),
        );
    }
}
