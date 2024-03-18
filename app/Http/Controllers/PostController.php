<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Post\StorePostRequest;
use App\Repositories\FileRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * @group Posts
 *
 * APIs for creating, updating and deleting posts.
 *
 */
class PostController extends Controller
{
    private FileRepository $fileRepository;
    private PostRepository $postRepository;

    public function __construct(FileRepository $fileRepository, PostRepository $postRepository)
    {
        $this->fileRepository = $fileRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * Store
     *
	 * Creates a new post.
     *
     * @bodyParam caption string optional Caption of the post. Example: "Tehran, Winter 2024"
     * @bodyParam slide_file[n] file required File to upload as the n-th slide of the post.
     * @bodyParam slide_order[n] integer required Order of the n-th file. Example: 1
     * @bodyParam slide_tag_user_id[m][n] integer optional Id of the n-th tagged user in m-th slide. Example: 1
     * @bodyParam slide_tag_horizontal_position integer optional Horizontal position of the n-th tag on the m-th slide in pixels. Example: 200
     * @bodyParam slide_tag_vertical_position integer optional Vertical position of the n-th tag on the m-th slide in pixels. Example: 200
     *
	 */
    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();

        try {

            // upload slide files and customize request inputs for storing post
            $payload = $request->all();
            foreach ($payload['slide_file'] as $index => $file) {
                // upload file on the server
                $fileRecord = $this->fileRepository->upload($file, 'post-slide');

                // customize request inputs
                $payload['slides'][$index]['file_id'] = $fileRecord->id;
                $payload['slides'][$index]['order'] = $payload['slide_order'][$index] ?? $index;

                $slideTags = array();
                if (array_key_exists('slide_tag_user_id', $payload) and array_key_exists($index, $payload['slide_tag_user_id'])) {
                    foreach ($payload['slide_tag_user_id'][$index] as $tagIndex => $userId) {
                        $slideTags[$tagIndex] = [
                            'tagged_user_id' => $userId,
                            'flag_horizontal_position' => $payload['slide_tag_horizontal_position'][$index][$tagIndex] ?? 0,
                            'flag_vertical_position' => $payload['slide_tag_vertical_position'][$index][$tagIndex] ?? 0,
                        ];
                    }
                }
                $payload['slides'][$index]['tags'] = $slideTags;
            }

            // create post record in database
            $post = $this->postRepository->store($payload);

            DB::commit();
        } catch (Exception $e) {

            Log::error(__CLASS__ . ' / ' . __FUNCTION__ . ' => ' . 'Uploading post failed: ' . $e->getMessage());

            DB::rollback();
        }

        // return response
        return prepareSuccessfulResponse(
            trans('messages.posts.successful.post_started_to_upload')
        );
    }
}
