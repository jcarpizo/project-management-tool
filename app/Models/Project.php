<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    use softDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'owner_id',
        'updater_user_id',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->whereNull('deleted_at');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function booted(): void
    {
        static::creating(fn ($model) => $model->{$model->getKeyName()} ??= (string) Str::uuid());
    }
}
