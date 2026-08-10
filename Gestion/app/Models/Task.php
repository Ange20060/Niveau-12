<?php

namespace App\Models;

use Dom\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
      'project_id',
      'title',
      'description',
      'status',
    ];

    public function project(): BelongsTo
    {
      return $this->belongsTo(Project::class);
    }

    public function comments(): HasMany
    {
      return $this->hasMany(Comment::class);
    }
}
