<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(new Profile());
    }

    public function findByUserId(int $userId)
    {
        $profile = $this->model->where('user_id', $userId)
            ->get()
            ->first();

        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = $userId;
            $profile->save();
        }

        return $profile;
    }
}