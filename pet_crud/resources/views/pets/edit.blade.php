<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Edit Pet</h1>

        <div class="card shadow p-4">
            <form method="POST" action="{{ route('pets.update', $pet->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <input type="text" name="type" class="form-control" value="{{ $pet->type }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Breed</label>
                    <input type="text" name="breed" class="form-control" value="{{ $pet->breed }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="Male" {{ $pet->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $pet->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control" value="{{ $pet->color }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Size</label>
                    <input type="text" name="size" class="form-control" value="{{ $pet->size }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" value="{{ $pet->age }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Weight</label>
                    <input type="number" step="0.01" name="weight" class="form-control" value="{{ $pet->weight }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($pet->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $pet->image) }}" width="100" class="img-thumbnail">
                        </div>
                    @endif
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Update Pet</button>
                </div>
            </form>
        </div>

        <div class="mt-3 text-center">
            <a href="{{ route('pets.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
