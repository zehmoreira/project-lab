<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePictureRequest;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Repositories\ProfileRepository;
use App\Services\ProfileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    
    public function show(Request $request, ProfileRepository $profileRepository)
    {
        $user = Auth::user();

        $profile = $profileRepository->findByUserId($user->id);

        return new ProfileResource($profile);
    }


    public function update(ProfileStoreRequest $request, ProfileManager $profileManager)
    {

        $user = Auth::user();

        $data = $request->all();

        $profile = $profileManager->save($data, $user);

        return new ProfileResource($profile);

    }

    public function changePicture(ChangePictureRequest $request, ProfileManager $profileManager)
    {
        $user = Auth::user();

        $profile = $profileManager->changePicture($request->file('picture'), $user);

        return (new ProfileResource($profile))
            ->response()
            ->setStatusCode(200);
        
    }

}
