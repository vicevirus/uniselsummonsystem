<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Student Data') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="overflow-x-auto">
            <table id="studentsTable" class="table">
                <thead>
                    <tr>
                        <th>Matric Number</th>
                        <th>Name</th>
                        <th>IC Number>
                        <th>Plate Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->matricNumber }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->icNumber }}</td>
                        <td>{{ $student->plateNumber }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="window.location.href='{{ route('admin.edit_student', $student->matricNumber) }}'">Edit</button>
                            <button class="btn  btn-sm mx-2" onclick="showQR('{{ $student->QRCodeId }}', '{{ $student->matricNumber }}')">Show
                                Sticker</button>
                            <button class="btn btn-error btn-sm" onclick="confirmDelete('{{ route('admin.delete_student', $student->matricNumber) }}')">Delete</button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </x-slot>
</x-app-layout>

<dialog id="my_modal_1" class="modal fixed inset-0 flex items-center justify-center z-50">
    <div class="modal-box rounded shadow-lg w-1/2 p-8 m-4">
        <h3 class="font-bold text-lg my-4 text-center">Student QR Code</h3>
        <img id="qrImage" src="" alt="QR Code" class="mx-auto">
        <div class="modal-action mt-5 text-center">
            <form method="dialog">
                <!-- if there is a button in form, it will close the modal -->
                <button class="btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Close</button>
                <button class="btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="downloadQR()">Save QR Code</button>
                <button class="btn bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded" onclick="printQR()">Print QR Code</button>
            </form>
        </div>
    </div>
</dialog>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#studentsTable').DataTable(); // Initialize DataTable on your table
    });


    function confirmDelete(url) {
        Swal.fire({
            title: '<h1 style="color:white">Are you sure?</h1>',

            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            background: 'gray', // Set the background color to gray
            customClass: {
                title: 'custom-title', // Apply custom style to the title
                icon: 'custom-icon', // Apply custom style to the icon
                confirmButton: 'custom-confirm-button' // Apply custom style to the confirm button
            },
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    let matricNumber; // Declare a variable to store matric number

    function showQR(qrCodeId, matricNum) {
        document.getElementById('qrImage').src = '/generate_qr/' + qrCodeId;
        matricNumber = matricNum; // Store matric number when showing QR
        my_modal_1.showModal();
    }

    function downloadQR() {
        let qrImage = document.getElementById('qrImage');
        let url = qrImage.src;
        let link = document.createElement('a');
        link.href = url;
        link.download = 'QRCode_' + matricNumber + '.png'; // Use matric number in file name
        link.click();
    }

    function printQR() {
        let qrImage = document.getElementById('qrImage');
        let url = qrImage.src;
        let win = window.open('');
        win.document.write('<img src="' + url + '" onload="window.print();window.close()" />');
        win.focus();
    }
</script>