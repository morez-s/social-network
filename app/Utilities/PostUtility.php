<?php

namespace App\Utilities;

use Illuminate\Support\Str;
use App\Models\Post;

class PostUtility
{
    public static function createUniqueShareLink(): string
    {
        $shareLink = '';
        while (true) {
            $shareLink = Str::random(32);

            $existedPostWithTheShareLink = Post::query()->where('share_link', $shareLink)->first();
            if (empty($existedPostWithTheShareLink)) {
                break;
            }
        }

        return $shareLink;
    }
}
