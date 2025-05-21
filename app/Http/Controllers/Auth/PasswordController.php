<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{


      /**
     * Update the current user’s password.
     *
     * @OA\Put(
     *   path="/api/user/password",
     *   tags={"Auth"},
     *   summary="Change the authenticated user’s password",
     *   security={{"sanctum": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"current_password","password","password_confirmation"},
     *       @OA\Property(property="current_password", type="string", format="password", example="oldSecret123"),
     *       @OA\Property(property="password", type="string", format="password", example="newSecret123"),
     *       @OA\Property(property="password_confirmation", type="string", format="password", example="newSecret123")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Password successfully updated"
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated"
     *   )
     * )
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}