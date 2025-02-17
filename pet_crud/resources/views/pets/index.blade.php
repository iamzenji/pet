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

</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Pet List</h1>

        <!-- Filter -->
        <form method="GET" action="{{ route('pets.index') }}" class="mb-4 p-3 bg-light rounded shadow-sm">
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
        </form>

        <div class="mb-3">
            <a href="{{ route('pets.create') }}" class="btn btn-success">Add New Pet</a>
        </div>

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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($pets as $pet)
                        <tr>
                            <td>{{ $pet->type }}</td>
                            <td>{{ $pet->breed }}</td>
                            <td>{{ $pet->gender }}</td>
                            <td>{{ $pet->color }}</td>
                            <td>{{ $pet->size }}</td>
                            <td>{{ $pet->age }}</td>
                            <td>{{ $pet->weight }} kg</td>
                            <td>
                                @if($pet->image)
                                    <img src="{{ asset('storage/' . $pet->image) }}" width="100" height="100" class="rounded img-thumbnail"
                                        data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('{{ asset('storage/' . $pet->image) }}')">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteAction({{ $pet->id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach --}}
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

    <!-- delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this pet?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script> --}}
    <script src="{{asset('assets/DataTables/datatables.min.js')}}"></script>
    <script>
        // $(document).ready(function() {
        //     $('#petTable').DataTable({
        //                 dom: 'Bfrtip',
        //                 buttons: [
        //                     'copy', 'csv', 'excel', 'pdf', 'print'
        //                 ]
        //                 });
        // })

        $.ajax({
            url: "/pet-list",
            success: function(result){
                $("#div1").html(result);
                var html = '';
                $.each(result, function(key,value) {

                    console.log( value.type );
                    html += '<tr>';
                    html += '<td>'+value.type+'</td>';
                    html += '<td>'+value.breed +'</td></tr>';
                });
                $('#sample').html(html);
            }
        });

    // function petFunction(){
    //     const DOM = "<'row'<'col-sm-12 col-md-8'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
    //     const A_LENGTH_MENU = [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']];
    //     var table = $('#petTable').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: {
    //             url: "/pet-list",
    //             type: 'GET',
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //         },
    //         columns: [
    //             {data: 'type'},
    //             {data: 'type'},
    //             {data: 'type'},
    //             {data: 'type'},
    //             {data: 'type'},
    //             {data: 'type'},
    //             {data: 'type'},
    //             {data: 'type'},
    //             {data: 'type'},
    //         ],
    //         dom: DOM,
    //         aLengthMenu: A_LENGTH_MENU,
    //         responsive: true,
    //         colReorder: true,
    //         autoWidth: false,
    //         bSort: true,
    //         paging: true,
    //         info: true,
    //         ordering: true,
    //         searching: true,
    //         // buttons: tableButtons,
    //     });
    //     return petFunction();
    // }

    // $(function() {
    //     $(".task-listing").click(function() {
    //         const DOM = "<'row'<'col-sm-12 col-md-8'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
    //             const A_LENGTH_MENU = [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']];
    //             var table = $('#petTable').DataTable({
    //                 processing: true,
    //                 serverSide: true,
    //                 ajax: {
    //                     url: "/pet-list",
    //                     type: 'GET',
    //                     headers: {
    //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                     },
    //                 },
    //                 columns: [
    //                     {data: 'type'},
    //                     {data: 'type'},
    //                     {data: 'type'},
    //                     {data: 'type'},
    //                     {data: 'type'},
    //                     {data: 'type'},
    //                     {data: 'type'},
    //                     {data: 'type'},
    //                     {data: 'type'},
    //                 ],
    //                 dom: DOM,
    //                 aLengthMenu: A_LENGTH_MENU,
    //                 responsive: true,
    //                 colReorder: true,
    //                 autoWidth: false,
    //                 bSort: true,
    //                 paging: true,
    //                 info: true,
    //                 ordering: true,
    //                 searching: true,
    //                 // buttons: tableButtons,
    //             });
    //         });
    //     });


            // var domSetup = "<'row'<'col-sm-12 col-md-8'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
            //     const A_LENGTH_MENU = [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']];
            //     $('#petTable').DataTable({
            //         processing: true,
            //         serverSide: true,
            //         ajax: {
            //             url: "/pet-list",
            //             type: 'GET',
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //         },
            //         columns: [
            //             {data: 'type'},
            //             {data: 'type'},
            //             {data: 'type'},
            //             {data: 'type'},
            //             {data: 'type'},
            //             {data: 'type'},
            //             {data: 'type'},
            //             {data: 'type'},
            //             {data: 'type'},
            //         ],
            //         dom: domSetup,
            //         aLengthMenu: A_LENGTH_MENU,
            //         responsive: true,
            //         colReorder: true,
            //         autoWidth: false,
            //         bSort: true,
            //         paging: true,
            //         info: true,
            //         ordering: true,
            //         searching: true,
            //         // buttons: tableButtons,
            //     });

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
                            {data: 'image'},
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
                        // buttons: tableButtons,
                    });
        });


        function showImage(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
        }

        function setDeleteAction(petId) {
            let form = document.getElementById('deleteForm');
            form.action = "/pets/" + petId;
        }


    </script>
</body>
</html>
