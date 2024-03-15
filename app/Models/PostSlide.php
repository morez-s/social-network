<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostSlide extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'file_id',
        'order',
    ];


    // *********** Relation Functions *********** //

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function postSlideTags(): HasMany
    {
        return $this->hasMany(PostSlideTag::class);
    }
}
