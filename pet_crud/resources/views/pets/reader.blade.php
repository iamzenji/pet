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
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded" alt="Preview">
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script> --}}
    <script src="{{asset('assets/DataTables/datatables.min.js')}}"></script>
    <script   script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function () {
        var domSetup = "<'row'<'col-sm-12 col-md-8'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        const A_LENGTH_MENU = [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']];
        let table = $('#petTable').DataTable({
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
                { data: 'type' },
                { data: 'breed' },
                { data: 'gender' },
                { data: 'color' },
                { data: 'size' },
                { data: 'age' },
                { data: 'weight' },
                {
                    data: 'image',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        console.log("Image Path:", data);
                        if (data) {
                            return `<img src="/storage/${data}" width="50" height="50" class="img-thumbnail"
                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                            onclick="showImage('/storage/${data}')">`;
                        } else {
                            return "No Image";
                        }
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

        });

    function showImage(imageUrl) {
        document.getElementById('modalImage').src = imageUrl;
    }


    return table;
    });
    </script>
    @endsection
</body>
</html>



