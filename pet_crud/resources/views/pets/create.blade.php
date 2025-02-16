<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Create a New Pet</h1>

        <div class="card shadow p-4">
            <form id="petForm" method="post" action="{{ route('pets.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <input type="text" name="type" class="form-control" placeholder="Enter pet type" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Breed</label>
                    <input type="text" name="breed" class="form-control" placeholder="Enter breed" required>
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
                    <input type="text" name="color" class="form-control" placeholder="Enter color" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Size</label>
                    <input type="text" name="size" class="form-control" placeholder="Enter size" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" placeholder="Enter age" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Weight</label>
                    <input type="number" step="0.01" name="weight" class="form-control" placeholder="Enter weight (kg)" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="d-grid">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                        Save Pet
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-3 text-center">
            <a href="{{ route('pets.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
    {{-- modal --}}
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
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
    <script>
        document.getElementById('confirmSubmit').addEventListener('click', function() {
            document.getElementById('petForm').submit();
        });
    </script>
</body>
</html>
