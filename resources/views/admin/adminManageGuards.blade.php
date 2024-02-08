<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Guard Data') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
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
                        <td><button class="btn btn-primary btn-sm" onclick="">Edit</button>

                            <button class="btn btn-error btn-sm" onclick="">Delete</button>
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

<script>
    $(document).ready(function() {
        $('#guardsTable').DataTable();
    });
</script>