<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'share_link',
        'page_id',
        'caption',
        'likes',
        'shares',
    ];


    // *********** Relation Functions *********** //

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function postSlides(): HasMany
    {
        return $this->hasMany(PostSlide::class);
    }

    public function postLikes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    public function postComments(): HasMany
    {
        return $this->hasMany(PostComment::class);
    }
}
