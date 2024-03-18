<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FileRepository
{
    private Builder $query;

    public function __construct()
    {
        $this->query = File::query();
    }

    /**
     * @param $file;
     * @param string $type;
     * @return Model
     */
    public function upload($file, string $file_type): ?Model
    {
        // get file name and type
        $file_name = $file->getClientOriginalName();
        $file_extension = $file->getClientOriginalExtension();
        $folder_name = $file_type . 's';

        // upload file on the server
        $file_path = $file->store($folder_name, 'public');
        $file_server_name = str_replace($folder_name . '/', '', $file_path);

        // create uploaded file information in database
        return $file = $this->query->create([
            'type' => $file_type,
            'extension' => $file_extension,
            'original_name' => $file_name,
            'server_name' => $file_server_name,
            'uploader_user_id' => 1,
        ]);
    }
}
