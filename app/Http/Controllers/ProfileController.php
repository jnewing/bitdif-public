<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Settings', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'APIEnabled' => config('app.enable_api'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Generate a ShareX configuration file.
     *
     * @param Request $request
     * @return void
     */
    public function sharex(Request $request): \Illuminate\Http\Response
    {
        $sharex_config = [
            "Version" => "16.1.0",
            "DestinationType" => "ImageUploader",
            "RequestMethod" => "POST",
            "RequestURL" => "https://bitdif.com/api/v1/upload",
            "Headers" => [
                "Authorization" => "Bearer {$request->user()->api_token}",
            ],
            "Body" => "MultipartFormData",
            "FileFormName" => "image",
            "URL" => "{json:data.link}",
        ];

        return response(json_encode($sharex_config), 200, [
            'Content-Type' => 'text/plain',
            'Content-Description' => 'bitdif.com.sxcu',
            'Content-Disposition' => 'attachment; filename="bitdif.com.sxcu"',
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the users API key.
     *
     * @param Request $request
     * @return void
     */
    public function apikey(Request $request): RedirectResponse
    {
        $token = base64_encode(bin2hex(random_bytes(10)));

        $request->user()->update([
            'api_token' => $token,
            'token_set_at' => Carbon::now(),
        ]);

        return Redirect::route('settings')
            ->with('message', $token);
    }



}
