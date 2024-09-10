<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        a, button {
            color: #007bff;
            text-decoration: none;
        }
        button {
            border: none;
            background: none;
            cursor: pointer;
            color: red;
        }
        button:hover {
            text-decoration: underline;
        }
        .map-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Locations</h1>
        <a href="{{ route('locations.create') }}" style="display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none;">Add Location</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locations as $location)
                    <tr>
                        <td>{{ $location->name }}</td>
                        <td>{{ $location->latitude }}</td>
                        <td>{{ $location->longitude }}</td>
                        <td>
                            <a href="{{ route('locations.edit', $location->id) }}">Edit</a>
                            <form action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div id="map" class="map-container" style="height: 500px;"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-6.9175, 107.6191], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($locations as $location)
            L.marker([{{ $location->latitude }}, {{ $location->longitude }}])
                .addTo(map)
                .bindPopup('{{ $location->name }}');
        @endforeach
    </script>
</body>
</html>
