<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Subject extends Model
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
        'sort_order' => 'integer',
    ];

    /**
     * توليد slug تلقائياً إذا لم يُقدَّم.
     */
    protected static function booted(): void
    {
        static::creating(function (Subject $subject): void {
            if (empty($subject->slug) && ! empty($subject->name)) {
                $subject->slug = Str::slug($subject->name);
            }
        });
    }

    /**
     * علاقة المادة بدروسها.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
