<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment Successful!') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="py-12">


            <!-- Success Message -->
            <div class="text-center">
                <div class="text-green-500 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="mb-5 text-xl font-semibold text-gray-800 dark:text-white">Thank You for Your Payment!</h3>
                <p class="text-gray-600 dark:text-gray-200 mb-8">Your transaction has been successfully processed, and your payment is received. You have paid your summon.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            </div>
        </div>

    </x-slot>
</x-app-layout>