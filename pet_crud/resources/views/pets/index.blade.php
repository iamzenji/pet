<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pet List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Pet List</h1>

        <!-- Filter Form -->
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
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="mb-3">
            <a href="{{ route('pets.create') }}" class="btn btn-success">Add New Pet</a>
        </div>

        <!-- Pets Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Type</th>
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
                    @foreach($pets as $pet)
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
                                <img src="{{ asset('storage/' . $pet->image) }}" width="50" height="50" class="rounded img-thumbnail"
                                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('{{ asset('storage/' . $pet->image) }}')">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this pet?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showImage(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    }
    </script>
</body>
</html>
