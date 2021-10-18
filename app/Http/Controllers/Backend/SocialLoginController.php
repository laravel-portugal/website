<?php

namespace App\Http\Controllers\Backend;

use App\Actions\UserAuthWithSocialAccountAction;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\RedirectResponse;
use function redirect;
use function route;

class SocialLoginController extends Controller
{
    public function redirect($provider): RedirectResponse
    {
        try {
            return \Socialite::driver($provider)
                ->with(['redirect_uri' => route('social.callback', ['provider' => $provider])])
                ->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }

    public function callback($provider): RedirectResponse
    {
        try {
            $providerUser = \Socialite::driver($provider)
                ->with(['redirect_uri' => route('social.callback', ['provider' => $provider])])
                ->user();

            if ($user = UserAuthWithSocialAccountAction::execute($provider, $providerUser)) {
                Auth::login($user);

                return redirect()->route('dashboard');
            }
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        return redirect()->route('login');
    }
}
