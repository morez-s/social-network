<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostCommentLike extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_comment_id',
        'user_id',
    ];


    // *********** Relation Functions *********** //

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
