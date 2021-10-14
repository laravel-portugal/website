<?php

namespace App\Actions;

use App\Models\User;
use App\Models\UserSocialAccount;
use Laravel\Socialite\AbstractUser;

class UserAuthWithSocialAccountAction
{
    public static function execute($provider, AbstractUser $providerUser): User
    {
        $account = UserSocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        // We have found the user on social accounts, return the relation ( user )
        if ($account) {
            return $account->user;
        }

        $user = User::whereEmail($providerUser->getEmail())->first();
        // Check if the user exists
        if (! $user) {
            $user = new User();
            $temporaryPassword = \Hash::make(\Str::random(10));
            $user->forceFill([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'password' => $temporaryPassword,
            ]);

            // TODO : Dispatch e-mail with password

            // If there is a nickname
            if ('' !== $providerUser->getNickname()) {
                $user->username = $providerUser->getNickname();
            }

            // Save
            $user->save();

            // Append avatar if any
            if ('' !== $providerUser->getAvatar()) {
                $file = url_to_upload_file($providerUser->getAvatar());
                $user->updateProfilePhoto($file);
            }
        }

        $user->social_accounts()->create([
            'provider_user_id' => $providerUser->getId(),
            'provider' => $provider,
            'data' => (array) $providerUser,
        ]);

        return $user;
    }
}
