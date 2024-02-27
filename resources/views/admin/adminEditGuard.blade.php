<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Guard Data') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="p-4 flex justify-center items-center">
            <form action="{{ route('admin.updateGuard', $guard->securityId) }}" method="POST" class="form-control w-full max-w-xs">
                @csrf
                @method('PUT')

                <!-- Security ID (Readonly) -->
                <label class="label">
                    <span class="label-text font-semibold">Security ID</span>
                </label>
                <input type="text" value="{{ $guard->securityId }}" class="input input-bordered w-full max-w-xs" readonly>

                <!-- Security Name (Readonly) -->
                <label class="label">
                    <span class="label-text font-semibold">Security Name</span>
                </label>
                <input type="text" value="{{ $guard->securityName }}" class="input input-bordered w-full max-w-xs" readonly>

                <!-- Guard Username (Readonly) -->
                <label class="label">
                    <span class="label-text font-semibold">Guard Username</span>
                </label>
                <input type="text" value="{{ $guard->guard_username }}" class="input input-bordered w-full max-w-xs" readonly>

                <!-- New Password (Editable) -->
                <label class="label">
                    <span class="label-text font-semibold">New Password</span>
                </label>
                <input type="password" name="password" placeholder="Enter new password" required class="input input-bordered w-full max-w-xs">

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mt-6">Update Password</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>