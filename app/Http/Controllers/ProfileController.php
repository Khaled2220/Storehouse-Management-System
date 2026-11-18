<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use App\Services\WebAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $profileService, private WebAuthService $authService)
    {
        //
    }

    public function index(Request $request): View
    {
        return view('profile.index')->with('user', $request->user());
    }

    public function edit(Request $request): View
    {
        return view('profile.edit')->with('user', $request->user());
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile($request->user(), $request->validated());

        return redirect()->route('profile')
            ->with('status', 'Profile-Updated-Successfully');
    }

    public function destroy(DeleteProfileRequest $request): RedirectResponse
    {
        $deleted = $this->profileService->deleteProfile($request->user());

        if (! $deleted) {
            return redirect()->route('profile')
                ->with('error', 'Your Account could not be Deleted.');
        }

        $this->authService->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Your Account has been Deleted Successfully.');
    }
}
