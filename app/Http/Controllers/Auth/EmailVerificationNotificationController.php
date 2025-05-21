<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
   /**
     * Send a new email verification notification to the authenticated user.
     *
     * @OA\Post(
     *   path="/api/email/verification-notification",
     *   tags={"Auth"},
     *   summary="Send email verification link",
     *   security={{"sanctum": {}}},
     *   @OA\Response(
     *     response=200,
     *     description="Verification link sent"
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated"
     *   )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
