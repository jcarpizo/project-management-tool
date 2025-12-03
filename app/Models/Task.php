<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;
    use softDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'project_id',
        'title',
        'status',
        'due_date',
        'assigned_to',
        'updater_user_id',
    ];

    protected static function booted(): void
    {
        static::creating(fn ($model) => $model->{$model->getKeyName()} ??= (string) Str::uuid());
    }
}
