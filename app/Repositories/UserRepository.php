<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    private Builder $query;

    public function __construct()
    {
        $this->query = User::query();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): ?Model
    {
        return $this->query->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
