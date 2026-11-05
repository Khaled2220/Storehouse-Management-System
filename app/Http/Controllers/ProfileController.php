<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\DeleteProfileRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $profileService)
    {
        //
    }

    public function index(Request $request)
    {
        return view('Profile.index')->with('user', $request->user());
    }

    public function edit(Request $request)
    {
        return view('Profile.edit')->with('user', $request->user());
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile(
            $request->user(),
            $request->validated()
        );

        return redirect()->route('profile')
            ->with('status', 'Profile-Updated-Successfully');
    }

    public function destroy(DeleteProfileRequest $request): RedirectResponse
    {
        $deleted = $this->profileService->deleteProfile(
            $request->user(),
            $request
        );
        if (!$deleted) {
            return redirect()->route('profile')
                ->with('error', 'Your Account could not be Deleted.');
        }
        return redirect()->route('login')
            ->with('success', 'Your Account has been Deleted Successfully.');
    }
}
