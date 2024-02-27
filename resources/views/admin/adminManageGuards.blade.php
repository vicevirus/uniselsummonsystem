<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Guard Data') }}
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
            <table id="guardsTable" class="table">
                <thead>
                    <tr>
                        <th>Security ID</th>
                        <th>Security Name</th>
                        <th>Guard Username</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guards as $guard)
                    <tr>
                        <td>{{ $guard->securityId }}</td>
                        <td>{{ $guard->securityName }}</td>
                        <td>{{ $guard->guard_username }}</td>
                        <td>{{ \Carbon\Carbon::parse($guard->created_at)->format('d-m-y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($guard->updated_at)->format('d-m-y') }}</td>
                        <td>
                            <a href="{{ route('admin.edit_guard', $guard->securityId) }}" class="btn btn-primary btn-sm">Edit</a>

                            <button class="btn btn-error btn-sm" onclick="confirmDeletion('{{ $guard->securityId }}')">Delete</button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <button class="my-4 btn btn-success" onclick="window.location.href='/admin/createGuard'">Add
            Guard</button>
    </x-slot>
</x-app-layout>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeletion(securityId) {
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
                // Redirect to the delete route
                window.location.href = `/admin/delete_guard/${securityId}`;
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#guardsTable').DataTable();
    });
</script>