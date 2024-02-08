<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pay summon') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="p-4 flex justify-center items-center">
            <form action="/paidSummon" method="POST" class="form-control w-full max-w-xs">
                @csrf
                <!-- Summon ID -->
                <label class="label">
                    <span class="label-text font-semibold">Summon ID</span>
                </label>
                <input type="text" name="summonId" value="{{$summon->summonId}}" class="input input-bordered w-full max-w-xs" required readonly>

                <!-- Violation -->
                <label class="label">
                    <span class="label-text font-semibold">Violation</span>
                </label>
                <input type="text" name="violation" value="{{$summon->violation}}" class="input input-bordered w-full max-w-xs" required readonly>

                <!-- Fine Amount -->
                <label class="label">
                    <span class="label-text font-semibold">Fine Amount (RM)</span>
                </label>
                <input type="number" name="fineAmount" value="{{$summon->fineAmount}}" class="input input-bordered w-full max-w-xs" required readonly>


                <!-- Pay Button -->
                <button type="submit" class="btn btn-primary mt-6">Pay</button>
            </form>
        </div>
    </x-slot>

</x-app-layout>