<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Create Pet</h1>
    <form method="post" action="{{ route('pets.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Type</label>
            <input type="text" name="type" placeholder="Enter pet type" required>
        </div>
        <div>
            <label>Breed</label>
            <input type="text" name="breed" placeholder="Enter breed" required>
        </div>
        <div>
            <label>Gender</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div>
            <label>Color</label>
            <input type="text" name="color" placeholder="Enter color" required>
        </div>
        <div>
            <label>Size</label>
            <input type="text" name="size" placeholder="Enter size" required>
        </div>
        <div>
            <label>Age</label>
            <input type="number" name="age" placeholder="Enter age" required>
        </div>
        <div>
            <label>Weight</label>
            <input type="number" step="0.01" name="weight" placeholder="Enter weight (kg)" required>
        </div>
        <div>
            <label>Image</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div>
            <input type="submit" value="Save a New Pet"/>
        </div>

    </form>
</body>
</html>