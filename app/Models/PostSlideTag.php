<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostSlideTag extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_slide_id',
        'tagged_user_id',
        'flag_horizontal_position',
        'flag_vertical_position',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'flag_horizontal_position' => 'float',
        'flag_vertical_position' => 'float',
    ];


    // *********** Relation Functions *********** //

    public function postSlide(): BelongsTo
    {
        return $this->belongsTo(PostSlide::class);
    }

    public function taggedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tagged_user_id');
    }
}
