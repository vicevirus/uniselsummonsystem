<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Student Data') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="p-4 flex justify-center items-center">
            <form action="{{ route('admin.updateStudent', $student->matricNumber) }}" method="POST" class="form-control w-full max-w-xs">
                @csrf
                @method('PUT')
                <!-- Assuming your route accepts PUT requests for updates -->

                <!-- Matric Number -->
                <label class="label">
                    <span class="label-text font-semibold">Matric Number</span>
                </label>
                <input type="text" name="matricNumber" value="{{ $student->matricNumber }}" class="input input-bordered w-full max-w-xs" readonly>

                <!-- Name -->
                <label class="label">
                    <span class="label-text font-semibold">Name</span>
                </label>
                <input type="text" name="name" value="{{ $student->name }}" required class="input input-bordered w-full max-w-xs">

                <!-- IC Number -->
                <label class="label">
                    <span class="label-text font-semibold">IC Number</span>
                </label>
                <input type="text" name="icNumber" value="{{ $student->icNumber }}" required class="input input-bordered w-full max-w-xs">

                <!-- Plate Number -->
                <label class="label">
                    <span class="label-text font-semibold">Plate Number</span>
                </label>
                <input type="text" name="plateNumber" value="{{ $student->plateNumber }}" required class="input input-bordered w-full max-w-xs">

                <!-- Phone Number -->
                <label class="label">
                    <span class="label-text font-semibold">Phone Number</span>
                </label>
                <input type="text" name="phoneNumber" value="{{ $student->phoneNumber }}" required class="input input-bordered w-full max-w-xs">

                <!-- Address -->
                <label class="label">
                    <span class="label-text font-semibold">Address</span>
                </label>
                <input type="text" name="address" value="{{ $student->address }}" required class="input input-bordered w-full max-w-xs">

                <!-- Car Type -->
                <label class="label">
                    <span class="label-text font-semibold">Car Type</span>
                </label>
                <input type="text" name="carType" value="{{ $student->carType }}" required class="input input-bordered w-full max-w-xs">

                <!-- Password -->
                <!-- Consider safety: typically, you wouldn't edit a password directly in such forms without specific actions -->
                <label class="label">
                    <span class="label-text font-semibold">New Password (optional)</span>
                </label>
                <input type="password" name="password" placeholder="Enter new password to change" class="input input-bordered w-full max-w-xs">

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mt-6">Update Student</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>