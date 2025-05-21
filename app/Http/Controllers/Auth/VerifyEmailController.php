<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */


     /**
     * Verify a user’s email address via signed link.
     *
     * @OA\Get(
     *   path="/api/email/verify/{id}/{hash}",
     *   tags={"Auth"},
     *   summary="Mark the authenticated user’s email as verified",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer"),
     *     description="User ID"
     *   ),
     *   @OA\Parameter(
     *     name="hash",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string"),
     *     description="SHA1 of the user’s email address"
     *   ),
     *   @OA\Response(
     *     response=302,
     *     description="Redirect to dashboard with `?verified=1`"
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Invalid or expired verification link"
     *   )
     * )
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
