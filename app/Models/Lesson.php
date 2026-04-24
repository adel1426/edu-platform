<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Lesson extends Model
{
    /**
     * السماح بالإدخال الجماعي لجميع الحقول (ما عدا id).
     */
    protected $guarded = ['id'];

    /**
     * تحويل أنواع الحقول تلقائياً.
     */
    protected $casts = [
        'is_published' => 'boolean',
        'points_reward' => 'integer',
    ];

    /**
     * توليد slug تلقائياً إذا لم يُقدَّم.
     */
    protected static function booted(): void
    {
        static::creating(function (Lesson $lesson): void {
            if (empty($lesson->slug) && ! empty($lesson->title)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });
    }

    /**
     * علاقة الدرس بالمادة التي ينتمي إليها.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
