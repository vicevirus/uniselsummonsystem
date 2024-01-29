<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Summon Data') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="overflow-x-auto">
            <table id="summonsTable" class="table">
                <thead>
                    <tr>
                        <th>Matric ID</th>
                        <th>Name</th>
                        <th>Plate Number</th>
                        <th>Violation</th>
                        <th>Fine Amount (RM)</th>
                        <th>Issued By</th>
                        <th>Due</th>
                        <th>Issued Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summons as $summon)
                    <tr>
                        <td>{{ $summon->student->matricNumber }}</td>
                        <td>{{ $summon->student->name }}</td>
                        <td>{{ $summon->student->plateNumber }}</td>
                        <td>{{ $summon->violation }}</td>
                        <td>RM {{ $summon->fineAmount  }}</td>
                        <td>{{ $summon->issuedBy }}</td>
                        <td>{{ \Carbon\Carbon::parse($summon->dueDate)->format('d-m-y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($summon->created_at)->format('d-m-y') }}</td>
                        <td><button class="btn btn-primary btn-sm mx-2" onclick="">Edit</button>

                            <button class="btn btn-error btn-sm" onclick="">Delete</button>
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
        $('#summonsTable').DataTable();
    });
</script>