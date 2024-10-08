<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        button, a.button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        button:hover, a.button:hover {
            background-color: #4cae4c;
        }
        .back-button {
            background-color: #0275d8;
            color: white;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Lokasi</h1>
        <form action="{{ route('locations.store') }}" method="POST">
            @csrf
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Enter location name" required>

            <label for="latitude">Latitude:</label>
            <input type="text" name="latitude" id="latitude" placeholder="Enter latitude" required>

            <label for="longitude">Longitude:</label>
            <input type="text" name="longitude" id="longitude" placeholder="Enter longitude" required>

            <label for="longitude">Description</label>
            <textarea name="description" id="description"></textarea>

            <button type="submit">Save</button>
            <button type="button" onclick="window.location.href='{{ route('map.index') }}'">Back to Map</button>
        </form>
    </div>
</body>
</html>
