<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

     /**
     * Confirm the user’s current password for sensitive actions.
     *
     * @OA\Post(
     *   path="/api/password/confirm",
     *   tags={"Auth"},
     *   summary="Verify the authenticated user’s password",
     *   security={{"sanctum": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"password"},
     *       @OA\Property(
     *         property="password",
     *         type="string",
     *         format="password",
     *         example="currentPassword123"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Password confirmed"
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Invalid password"
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated"
     *   )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
