<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View Summons Record') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="overflow-x-auto">
            <table id="summonsTable" class="table">
                <thead>
                    <tr>
                        <th>Violation</th>
                        <th>Fine Amount</th>
                        <th>Due Date</th>
                        <th>Issued By</th>
                        <th>Action</th>
                        <!-- Add more column headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($summonsRecords as $record)
                    <tr>
                        <td>{{ $record->violation }}</td>
                        <td>{{ $record->fineAmount }}</td>
                        <td>{{ $record->dueDate->format('Y-m-d') }}</td>
                        <td>{{ $record->issuedBy }}</td>
                        <td>
                            @if ($record->status == 'paid')
                            <a class="btn btn-success w-24 opacity-50 text-white  text-center">Paid</a>
                            @else
                            <a href="{{ route('paySummon', ['summonId' => $record->summonId]) }}" class="btn btn-primary w-24 text-center text-white">Pay Summon</a>
                            @endif
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#summonsTable').DataTable(); // Initialize DataTable on your table
    });
</script>