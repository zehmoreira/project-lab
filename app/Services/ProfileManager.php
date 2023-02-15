<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use App\Repositories\ProfileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileManager 
{

    private ProfileRepository $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function save(array $data, User $user) : Profile
    {
        try {

            DB::beginTransaction();

            $profile = $this->profileRepository->findByUserId($user->id);

            $profile->fill($data);
            $profile->save();

            DB::commit();

            return $profile;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function changePicture(UploadedFile $file, User $user)
    {
        try {
            DB::beginTransaction();

            $profile = $this->profileRepository->findByUserId($user->id);

            $profile->picture = $file->store('pictures/');
            $profile->save();

            DB::commit();

            return $profile;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
    }

}