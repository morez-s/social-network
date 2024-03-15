<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class UserRepository
{
    private Builder $query;

    public function __construct()
    {
        $this->query = User::query();
        $this->profileQuery = UserProfile::query();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): ?Model
    {
        DB::beginTransaction();

        try {

            // create user record in database
            $user = $this->query->create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // create profile record for the user in database
            $user->profile()->create();

            // create page record for the user in database
            $user->page()->create();

            DB::commit();

            return $user;

        } catch (Exception $e) {

            Log::info('User registration process failed: ' . $e->getMessage());

            DB::rollback();

            return null;

        }
    }
}
