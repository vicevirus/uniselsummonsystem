<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('guard.login') }}">
        @csrf

        <!-- Guard Username -->
        <div>
            <x-input-label for="guard_username" :value="__('Guard Login')" />
            <x-text-input id="guard_username" class="block mt-1 w-full" type="text" name="guard_username" :value="old('guard_username')" required autofocus />
            <x-input-error :messages="$errors->get('guard_username')" class="mt-2" />
        </div>

        <!-- Guard Password -->
        <div class="mt-4">
            <x-input-label for="guard_password" :value="__('Password')" />
            <x-text-input id="guard_password" class="block mt-1 w-full"
                            type="password"
                            name="guard_password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('guard_password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('guard.password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('guard.password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

          

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
