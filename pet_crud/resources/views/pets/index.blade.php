<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pet List</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" /> --}}
    <link type ="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></link>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/DataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container mt-4">
        <h1 class="text-center">Pet List</h1>

        <!-- Filter -->
        {{-- <form method="GET" action="{{ route('pets.index') }}" class="mb-4 p-3 bg-light rounded shadow-sm">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Type:</label>
                    <input type="text" name="type" value="{{ request('type') }}" class="form-control" placeholder="Enter pet type">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Breed:</label>
                    <input type="text" name="breed" value="{{ request('breed') }}" class="form-control" placeholder="Enter breed">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gender:</label>
                    <select name="gender" class="form-select">
                        <option value="">All</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-20" ><i class="bi bi-funnel"></i></button>
                </div>
            </div>
        </form> --}}

        {{-- <div class="mb-3">
            <a href="{{ route('pets.create') }}" class="btn btn-success">Add New Pet</a>
        </div> --}}

        <!-- Pets Table -->
        <div class="table-responsive">
            <table id="petTable"  class="table table-striped">
                <thead>
                    <tr>
                        <th>Pet Type</th>
                        <th>Breed</th>
                        <th>Gender</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Age</th>
                        <th>Weight</th>
                        <th>Image</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- image -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pet Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPetModal" tabindex="-1" aria-labelledby="addPetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create a New Pet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="petForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Type</label>
                                    <input type="text" name="type" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Breed</label>
                                    <input type="text" name="breed" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Color</label>
                                    <input type="text" name="color" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Size</label>
                                    <input type="text" name="size" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Age</label>
                                    <input type="number" name="age" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Weight</label>
                                    <input type="number" step="0.01" name="weight" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                                Save Pet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to add this pet?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmSubmit">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script> --}}
    <script src="{{asset('assets/DataTables/datatables.min.js')}}"></script>
    <script   script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            var domSetup = "<'row'<'col-sm-12 col-md-8'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
            const A_LENGTH_MENU = [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']];
            return    $('#petTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/pet-list",
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        },
                        columns: [
                            {data: 'type'},
                            {data: 'breed'},
                            {data: 'gender'},
                            {data: 'color'},
                            {data: 'size'},
                            {data: 'age'},
                            {data: 'weight'},
                            {
                                data: 'image',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    if (data) {
                                        return `<img src="/storage/${data}" width="50" height="50" class="img-thumbnail"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                onclick="showImage('/storage/${data}')">`;
                                    } else {
                                        return "No Image";
                                    }
                                }
                            },
                            {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                            return `
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#deleteModal${row.id}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Pet</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editPetForm">
                                                    <input type="hidden" id="editPetId" name="id">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="editType" class="form-label">Type</label>
                                                                <input type="text" class="form-control" id="editType" name="type">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editBreed" class="form-label">Breed</label>
                                                                <input type="text" class="form-control" id="editBreed" name="breed">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editGender" class="form-label">Gender</label>
                                                                <select class="form-select" id="editGender" name="gender">
                                                                    <option value="Male">Male</option>
                                                                    <option value="Female">Female</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editColor" class="form-label">Color</label>
                                                                <input type="text" class="form-control" id="editColor" name="color">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="editSize" class="form-label">Size</label>
                                                                <input type="text" class="form-control" id="editSize" name="size">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editAge" class="form-label">Age</label>
                                                                <input type="number" class="form-control" id="editAge" name="age">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editWeight" class="form-label">Weight</label>
                                                                <input type="text" class="form-control" id="editWeight" name="weight">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 text-center">
                                                        <label class="form-label">Current Image</label>
                                                        <br>
                                                        <img id="editPetImage" src="/images/default.png" alt="Pet Image" class="img-thumbnail" width="150">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editImage" class="form-label">Upload New Image</label>
                                                        <input type="file" class="form-control" id="editImage" name="image">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update Pet</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal${row.id}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this pet?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-danger confirm-delete" data-id="${row.id}">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    }
                        ],
                        dom: domSetup,
                        aLengthMenu: A_LENGTH_MENU,
                        responsive: true,
                        colReorder: true,
                        autoWidth: false,
                        bSort: true,
                        paging: true,
                        info: true,
                        ordering: true,
                        searching: true,
                        buttons: [
                            {
                                text: '<i class="bi bi-plus-lg"></i> Add',
                                className: 'btn btn-secondary',
                                action: function (e, dt, node, config) {
                                    $('#addPetModal').modal('show');
                                }
                            },
                            {
                                extend: 'copy',
                                text: '<i class="bi bi-clipboard"></i> Copy',
                                className: 'btn btn-secondary'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                                className: 'btn btn-secondary'
                            },
                            {
                                extend: 'csv',
                                text: '<i class="bi bi-file-earmark-text"></i> CSV',
                                className: 'btn btn-secondary'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                                className: 'btn btn-secondary'
                            },
                            {
                                extend: 'print',
                                text: '<i class="bi bi-printer"></i> Print',
                                className: 'btn btn-secondary'
                            }
                        ]

                    });
                });
                function showImage(imageUrl) {
                    document.getElementById('modalImage').src = imageUrl;
                }
                function setDeleteAction(petId) {
                    let form = document.getElementById('deleteForm');
                    form.action = "/pets/" + petId;
                }
                //delete without reload
                $(document).on("click", ".confirm-delete", function () {
                    let petId = $(this).data("id");
                    $.ajax({
                        url: "/pets/" + petId,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function (response) {
                            if (response.success) {
                                $("#petTable").DataTable().row($(`button[data-id="${petId}"]`).parents("tr")).remove().draw();

                                $("#deleteModal" + petId).modal("hide");
                                // SweetAlert
                                Swal.fire({
                                    icon: "success",
                                    title: "Pet Deleted!",
                                    text: "The pet has been successfully deleted.",
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "OK",
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Deletion Failed!",
                                    text: "Failed to delete the pet. Please try again.",
                                    confirmButtonColor: "#d33",
                                    confirmButtonText: "OK",
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: "Something went wrong while deleting the pet.",
                                confirmButtonColor: "#d33",
                                confirmButtonText: "OK",
                            });
                        },
                    });
            });

            // edit ajax
            $(document).ready(function () {
            $(document).on("click", ".edit-btn", function () {
                let petId = $(this).data("id");

                $.ajax({
                    url: `/pets/${petId}/edit`,
                    type: "GET",
                    success: function (data) {

                        $("#editPetId").val(data.id);
                        $("#editType").val(data.type);
                        $("#editBreed").val(data.breed);
                        $("#editGender").val(data.gender);
                        $("#editColor").val(data.color);
                        $("#editSize").val(data.size);
                        $("#editAge").val(data.age);
                        $("#editWeight").val(data.weight);
                        let imageUrl = data.image ? `/storage/${data.image}` : "/images/default.png";
                        $("#editPetImage").attr("src", imageUrl);

                        $("#editModal").modal("show");
                    },
                    error: function () {
                        Swal.fire("Error!", "Failed to fetch pet data.", "error");
                    }
                });
            });
                $(document).on("submit", "#editPetForm", function (e) {
                e.preventDefault();

                let petId = $("#editPetId").val();
                let formData = new FormData(this);
                formData.append("_method", "PUT");

                $.ajax({
                    url: `/pets/${petId}`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Updated!",
                                text: "Pet details have been updated successfully.",
                            });

                            $("#editModal").modal("hide")
                            $("#petTable").DataTable().ajax.reload();
                        } else {
                            Swal.fire("Error!", "Failed to update pet details.", "error");
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire("Error!", "Something went wrong.", "error");
                    },
                });
            });

        });

        // Add data ajax
        $(document).ready(function() {
        let table = $('#petsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pets.index') }}",
            columns: [
                { data: 'id' },
                { data: 'type' },
                { data: 'breed' },
                { data: 'gender' },
                { data: 'color' },
                { data: 'size' },
                { data: 'age' },
                { data: 'weight' },
                { data: 'image', render: function(data) {
                    return `<img src="/storage/${data}" width="50">`;
                }},
                { data: 'created_at' }
            ]
        });

        $('#confirmSubmit').click(function() {
            let formData = new FormData($('#petForm')[0]);

            $.ajax({
                url: "{{ route('pets.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#addPetModal').modal('hide');
                        $('#confirmationModal').modal('hide');
                        $('#petForm')[0].reset();

                        table.row.add(response.data).draw(false);
                        Swal.fire({
                            title: 'Success!',
                            text: 'Pet added successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Something went wrong. Please try again!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
    </script>
    @endsection
</body>
</html>



