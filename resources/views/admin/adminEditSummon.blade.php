<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Summon Data') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="p-4 flex justify-center items-center">
            <form action="{{ route('admin.updateSummon', $summon->summonId) }}" method="POST" class="form-control w-full max-w-xs">
                @csrf

                @method('PUT')


                <!-- Summon ID (Disabled) -->
                <label class="label">
                    <span class="label-text font-semibold">Summon ID</span>
                </label>
                <input type="text" value="{{ $summon->summonId }}" class="input input-bordered w-full max-w-xs" disabled>

                <!-- Matric Number (Disabled) -->
                <label class="label">
                    <span class="label-text font-semibold">Matric Number</span>
                </label>
                <input type="text" value="{{ $summon->student->matricNumber }}" class="input input-bordered w-full max-w-xs" disabled>

                <!-- Name (Disabled) -->
                <label class="label">
                    <span class="label-text font-semibold">Name</span>
                </label>
                <input type="text" value="{{ $summon->student->name }}" class="input input-bordered w-full max-w-xs" disabled>

                <!-- Plate Number (Disabled) -->
                <label class="label">
                    <span class="label-text font-semibold">Plate Number</span>
                </label>
                <input type="text" value="{{ $summon->student->plateNumber }}" class="input input-bordered w-full max-w-xs" disabled>

                <!-- Violation (Editable) -->
                <label class="label">
                    <span class="label-text font-semibold">Violation</span>
                </label>
                <input type="text" name="violation" value="{{ $summon->violation }}" required class="input input-bordered w-full max-w-xs">

                <!-- Fine Amount (Editable) -->
                <label class="label">
                    <span class="label-text font-semibold">Fine Amount (RM)</span>
                </label>
                <input type="text" name="fineAmount" value="{{ $summon->fineAmount }}" required class="input input-bordered w-full max-w-xs">

                <!-- Issued Date (Disabled) -->
                <label class="label">
                    <span class="label-text font-semibold">Issued Date</span>
                </label>
                <input type="text" value="{{ \Carbon\Carbon::parse($summon->created_at)->format('d-m-y') }}" class="input input-bordered w-full max-w-xs" disabled>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mt-6">Update Summon</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>