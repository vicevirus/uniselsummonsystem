<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Summon Data') }}
        </h2>
    </x-slot>

    <x-slot name="slot">

        @if(session('success'))
        <div class="alert alert-success my-5">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger my-5">
            {{ session('error') }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table id="summonsTable" class="table">
                <thead>
                    <tr>
                        <th>Summon ID</th>
                        <th>Matric ID</th>
                        <th>Name</th>
                        <th>Plate Number</th>
                        <th>Violation</th>
                        <th>Fine Amount (RM)</th>
                        <th>Issued By</th>
                        <th>Due</th>
                        <th>Issued Date</th>
                        <th>Status</th> <!-- Added Status Column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summons as $summon)
                    <tr>
                        <td>{{ $summon->summonId }}</td>
                        <td>{{ $summon->student->matricNumber }}</td>
                        <td>{{ $summon->student->name }}</td>
                        <td>{{ $summon->student->plateNumber }}</td>
                        <td>{{ $summon->violation }}</td>
                        <td>RM {{ $summon->fineAmount  }}</td>
                        <td>{{ $summon->issuedBy }}</td>
                        <td>{{ \Carbon\Carbon::parse($summon->dueDate)->format('d-m-y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($summon->created_at)->format('d-m-y') }}</td>
                        <td>
                            @if ($summon->status == 'paid')
                            <span class="text-green-500">Paid</span>
                            @else
                            <span class="text-red-500">Unpaid</span>
                            @endif
                        </td>
                        <td>

                            <a href="{{ route('admin.edit_summon', ['summonId' => $summon->summonId]) }}" class="btn btn-primary btn-sm ">Edit</a>
                            <button onclick="confirmDelete('{{ $summon->summonId }}')" class="btn btn-error btn-sm">Delete</button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(summonId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform a redirect to the delete route
                window.location.href = `/admin/delete_summon/${summonId}`; // Adjust the URL to match your actual route
            }
        });
    }
</script>


<script>
    $(document).ready(function() {
        $('#summonsTable').DataTable();
    });
</script>