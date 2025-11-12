<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request): RedirectResponse
    {
     /*   if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        */
// Read id/hash from route
        $id = $request->route('id');
        $hash = $request->route('hash');

        // 1) Optional: ensure the signed URL is valid (prevents tampering)
        if (! URL::hasValidSignature($request)) {
            abort(403, 'Invalid or expired verification link.');
        }

        // 2) Find the user
        $user = User::find($id);
        if (! $user) {
            abort(404, 'User not found.');
        }

        // 3) Verify that the hash matches the user's email (same check as Laravel)
        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            abort(403, 'Invalid verification link.');
        }

        // 4) If not authenticated, log the user in (admin-created case)
        if (! Auth::check()) {
            Auth::login($user);
        }

        // 5) If already verified, redirect (no-op)
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard') . '?verified=1');
        }

        // 6) Mark email as verified and dispatch the Verified event
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // 7) Redirect where you want (password set page, dashboard, etc.)
        return redirect()->intended(route('dashboard') . '?verified=1');
    }

}
