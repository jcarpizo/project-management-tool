<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    protected $hidden = [
        'owner_id',
        'updater_user_id',
    ];

    protected $appends = ['progress'];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->whereNull('deleted_at');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    protected static function booted(): void
    {
        static::creating(fn ($model) => $model->{$model->getKeyName()} ??= (string) Str::uuid());
    }

    protected function progress(): Attribute
    {
        return Attribute::get(function () {
            $tasks = $this->relationLoaded('tasks') ? $this->tasks : $this->tasks()->get();
            $total = $tasks->count();
            if ($total === 0) return 0;
            return round($tasks->where('status', 'done')->count() / $total * 100);
        });
    }
}
