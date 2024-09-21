<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- Leaflet Draw CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
    <!-- Leaflet Draw JS -->
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e9ecef;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
            color: #fff;
            border-right: 1px solid #0056b3;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-sizing: border-box;
            z-index: 1000;
            transition: width 0.3s;
        }

        .sidebar:hover {
            width: 270px;
        }

        .sidebar h2 {
            margin-top: 0;
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        .sidebar .location-item {
            margin-bottom: 15px;
        }

        .sidebar .location-item a {
            color: #e9ecef;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar .location-item a:hover {
            background-color: #0056b3;
            text-decoration: underline;
        }

        .menu-button {
            font-size: 18px;
            font-weight: bold;
            background: none;
            border: none;
            cursor: pointer;
            color: #fff;
            display: block;
            margin-bottom: 10px;
            width: 100%;
            text-align: left;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .menu-button:hover {
            background-color: #0056b3;
        }

        .menu-content {
            margin-left: 10px;
        }

        .menu-item {
            background: none;
            border: none;
            color: #fff;
            text-align: left;
            padding: 5px 0;
            cursor: pointer;
            display: block;
            width: 100%;
        }

        .menu-item:hover {
            background-color: #0056b3;
        }

        .menu-link {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 5px 0;
        }

        .menu-link:hover {
            text-decoration: underline;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            height: 100vh;
            box-sizing: border-box;
            overflow: auto;
        }

        .container {
            width: 100%;
            height: calc(100vh - 40px);
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-sizing: border-box;
        }

        #map {
            height: 500px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px 0;
            border: none;
            border-radius: 6px;
            background-color: #ffc107;
            color: #212529;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #e0a800;
            transform: scale(1.05);
        }

        .btn:active {
            transform: scale(0.98);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>

<body>
    @include('sidebar', ['locations' => $locations])
    <div class="content">
        <div class="container">
            <h1>
                <center>Map Kota Bandung</center>
            </h1>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Tombol untuk menambah lokasi baru -->
            <a href="{{ route('locations.create') }}" class="btn">Tambah Lokasi</a>

            <!-- Peta -->
            <div id="map"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
    <script>
        var map = L.map('map').setView([-6.9175, 107.6191], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: true,
                polyline: true,
                rectangle: true,
                circle: true,
                marker: true,
                circlemarker: true
            }
        });
        map.addControl(drawControl);

        // Handle the creation of new polygons
        map.on(L.Draw.Event.CREATED, function(e) {
            var layer = e.layer;
            var geojson = layer.toGeoJSON(); // Convert drawn shape to GeoJSON format
            var polygon = JSON.stringify(geojson.geometry); // Convert to string

            // Add layer to the drawn items layer group
            drawnItems.addLayer(layer);

            // Prompt for location name and description
            var name = prompt("Enter location name:");
            var description = prompt("Enter location description:");

            if (name && description) {
                // Save to the database via AJAX request
                savePolygonToDatabase(name, description, polygon);
            } else {
                alert("Name and description are required to save the polygon.");
            }
        });

        function savePolygonToDatabase(name, description, polygon) {
            fetch("{{ route('locations.storePolygon') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: name,
                        description: description,
                        polygon: polygon
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Polygon saved successfully!');
                    } else {
                        alert('Failed to save polygon.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }



        // Fungsi untuk mendapatkan warna acak
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Loop through locations and add polygons
        @foreach ($locations as $location)
            @if ($location->polygon)
                // Parse the polygon data (assumes GeoJSON format)
                var polygonData = {!! $location->polygon !!}; // Ensure polygon is stored as valid GeoJSON
                var polygonLayer = L.geoJSON(polygonData, {
                    style: function() {
                        return {
                            color: getRandomColor(), // Apply random color
                            fillOpacity: 0.7, // Optional: adjust fill opacity
                            weight: 2
                        };
                    }
                }).addTo(map);

                polygonLayer.bindPopup(`
                <div style="font-size: 14px;">
                    <b>{{ $location->name }}</b><br>
                    <a href="{{ route('locations.edit', $location->id) }}" class="btn" style="background-color: #ffc107; color: #212529;">Edit</a>
                    <form action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background-color: #dc3545; color: #fff;" onclick="return confirm('Are you sure you want to delete this location?');">Delete</button>
                    </form>
                    <a href="{{ route('locations.show', $location->id) }}" class="btn" style="background-color: #ffc107; color: #212529;">Info</a>
                </div>
            `);
            @endif
        @endforeach
    </script>

</body>


</html>
