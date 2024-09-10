<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Details</title>
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
        .details {
            margin-bottom: 20px;
        }
        .button-group {
            margin-top: 20px;
        }
        .button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        .button:hover {
            background-color: #4cae4c;
        }
        .button-back {
            background-color: #0275d8;
        }
        .button-back:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Location Details</h1>
        <div class="details">
            <p><strong>Name:</strong> {{ $location->name }}</p>
            <p><strong>Latitude:</strong> {{ $location->latitude }}</p>
            <p><strong>Longitude:</strong> {{ $location->longitude }}</p>
            <p><strong>Description:</strong> {{ $location->description }}</p>
        </div>
        <div class="button-group">
            <a href="{{ route('locations.edit', $location->id) }}" class="button">Edit</a>
            <a href="{{ route('map.index') }}" class="button button-back">Back to Map</a>
        </div>
    </div>
</body>
</html>
