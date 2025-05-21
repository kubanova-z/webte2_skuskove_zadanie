<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the authenticated user’s profile.
     *
     * @OA\Put(
     *   path="/api/profile",
     *   tags={"Profile"},
     *   summary="Update name and email for the current user",
     *   security={{"sanctum": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Jane Doe"),
     *       @OA\Property(property="email", type="string", format="email", example="jane@example.com")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Profile updated"),
     *   @OA\Response(response=422, description="Validation error"),
     *   @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the authenticated user’s account.
     *
     * @OA\Delete(
     *   path="/api/profile",
     *   tags={"Profile"},
     *   summary="Delete current user account",
     *   security={{"sanctum": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"password"},
     *       @OA\Property(property="password", type="string", format="password", example="currentPassword123")
     *     )
     *   ),
     *   @OA\Response(response=204, description="Account deleted"),
     *   @OA\Response(response=422, description="Validation error"),
     *   @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
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
     * Change the authenticated user’s password.
     *
     * @OA\Put(
     *   path="/api/profile/password",
     *   tags={"Profile"},
     *   summary="Update current user password",
     *   security={{"sanctum": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"current_password","new_password","new_password_confirmation"},
     *       @OA\Property(property="current_password", type="string", format="password", example="oldSecret123"),
     *       @OA\Property(property="new_password", type="string", format="password", example="newSecret123"),
     *       @OA\Property(property="new_password_confirmation", type="string", format="password", example="newSecret123")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Password updated"),
     *   @OA\Response(response=422, description="Validation error"),
     *   @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }
}
