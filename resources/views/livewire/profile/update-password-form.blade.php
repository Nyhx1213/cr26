<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;
use App\Models\User;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $showSuccess = false;
    /**
     * Update the password for the currently authenticated user.
     */
    /*
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
        */

    //Function sans current password

        public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('password', 'password_confirmation');

            throw $e;
        }

        $user = User::find(Auth::id());
        
        $user->password = Hash::make($validated['password']);
        $user->save();

        $this->reset('password', 'password_confirmation');
        $this->showSuccess = true;
        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Mises a jour du mot de passe') }}
        </h2>

    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <?php /*<div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div> */
        ?>
        @if($showSuccess)
                <div class="mt-4 p-4 bg-green-100 text-green-800 rounded-md font-medium">
                    {{ __('Votre mot de passe a été mis à jour!') }}
                </div>
        @endif

        <div>
            <x-input-label for="update_password_password" :value="__('Nouveaux mot de passe')" />
            <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmation du mot de passe')" />
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="detail-supression" style="margin:15px">
            <x-primary-button>{{ __('Valider') }}</x-primary-button>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Sauvgardé.') }}
            </x-action-message>
        </div>
    </form>
</section>
