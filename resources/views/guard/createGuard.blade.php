<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Security Guard') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="p-4 flex justify-center items-center">
            <form action="/admin/storeGuard" method="POST" class="form-control w-full max-w-xs">
                @csrf
                <!-- Security Name -->
                <label class="label">
                    <span class="label-text font-semibold">Security Name</span>
                </label>
                <input type="text" name="security_name" class="input input-bordered w-full max-w-xs" required>

                <!-- Username -->
                <label class="label">
                    <span class="label-text font-semibold">Username</span>
                </label>
                <input type="text" name="guard_username" class="input input-bordered w-full max-w-xs" required>

                <!-- Password -->
                <label class="label">
                    <span class="label-text font-semibold">Password</span>
                </label>
                <input type="password" name="guard_password" class="input input-bordered w-full max-w-xs" required>

                <!-- Add Guard Button -->
                <button type="submit" class="btn btn-primary mt-6">Add Guard</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>