<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <div class="overflow-x-auto">
                                    <table id="adminDataTable" class="table">
                                        <thead>
                                            <tr>
                                                <th>Matric Number</th>
                                                <th>Name</th>
                                                <th>Plate Number</th>
                                                <th>Car Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                            @if ($student->QRCodeId === null)
                                            <tr>
                                                <td>{{ $student->matricNumber }}</td>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->plateNumber }}</td>
                                                <td>{{ $student->carType }}</td>
                                                <td>
                                                    <button onclick="approveStudent('{{ route('admin.approveStudent', $student->matricNumber) }}')" class="btn btn-primary text-white">Approve</button>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <form id="approveForm" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#adminDataTable').DataTable();
    });

    function approveStudent(url) {
        Swal.fire({
            title: '<h1 style="color:white">Are you sure?</h1>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!',
            background: 'gray', // Enable dark mode
        }).then((result) => {
            if (result.isConfirmed) {
                var form = document.getElementById('approveForm');
                form.action = url;
                form.submit();
            }
        })
    }
</script>