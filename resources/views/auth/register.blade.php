<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Matric Number -->
        <div>
            <x-input-label for="matricNumber" :value="__('Matric Number')" />
            <x-text-input id="matricNumber" class="block mt-1 w-full" type="text" name="matricNumber" :value="old('matricNumber')" required autofocus autocomplete="matricNumber" />
            <x-input-error :messages="$errors->get('matricNumber')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- IC Number -->
        <div class="mt-4">
            <x-input-label for="icNumber" :value="__('IC Number')" />
            <x-text-input id="icNumber" class="block mt-1 w-full" type="text" name="icNumber" :value="old('icNumber')" required autocomplete="icNumber" />
            <x-input-error :messages="$errors->get('icNumber')" class="mt-2" />
        </div>

        <!-- Plate Number -->
        <div class="mt-4">
            <x-input-label for="phoneNumber" :value="__('Phone Number')" />
            <x-text-input id="phoneNumber" class="block mt-1 w-full" type="text" name="phoneNumber" :value="old('phoneNumber')" autocomplete="phoneNumber" />
            <x-input-error :messages="$errors->get('phoneNumber')" class="mt-2" />
        </div>

        <!-- Plate Number -->
        <div class="mt-4">
            <x-input-label for="plateNumber" :value="__('Plate Number')" />
            <x-text-input id="plateNumber" class="block mt-1 w-full" type="text" name="plateNumber" :value="old('plateNumber')" autocomplete="plateNumber" />
            <x-input-error :messages="$errors->get('plateNumber')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" autocomplete="address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Car Type -->
        <div class="mt-4">
            <x-input-label for="carType" :value="__('Car Type')" />
            <x-text-input id="carType" class="block mt-1 w-full" type="text" name="carType" :value="old('carType')" autocomplete="carType" />
            <x-input-error :messages="$errors->get('carType')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>


            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>