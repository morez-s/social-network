<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Utilities\PostUtility;
use Illuminate\Support\Facades\DB;

/**
 * Class PostRepository.
 */
class PostRepository
{
    private Builder $query;

    public function __construct()
    {
        $this->query = Post::query();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): ?Model
    {
        DB::beginTransaction();

        try {

            $share_link = PostUtility::createUniqueShareLink();

            // create post record in database
            $post = $this->query->create([
                'share_link' => $share_link,
                'page_id' => auth()->user()->page->id,
                'caption' => $data['caption'],
            ]);

            // create slide records for the post in database
            foreach ($data['slides'] as $slide) {
                $postSlide = $post->postSlides()->create($slide);

                // create tag records for the post slide in database
                foreach ($slide['tags'] as $tag) {
                    $postSlide->postSlideTags()->create($tag);
                }
            }

            DB::commit();

            return $post;

        } catch (Exception $e) {

            Log::error(__CLASS__ . ' => ' . 'Uploading post process failed: ' . $e->getMessage());

            DB::rollback();

            return null;

        }
    }
}
