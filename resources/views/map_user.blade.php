<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
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
            /* Width of the sidebar */
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
            height: 350px;
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
    <div class="sidebar">
        <h2>Lokasi</h2>
        @foreach ($locations as $location)
            <div class="location-item">
                <a href="#marker-{{ $location->id }}">{{ $location->name }}</a>
            </div>
        @endforeach
    </div>
    <div class="content">
        <div class="container">
            <h1>
                <center>Map Kota Bandung</center>
            </h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Peta -->
            <div id="map"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-6.9175, 107.6191], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($locations as $location)
            var marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}])
                .addTo(map)
                .bindPopup(`
                <div style="font-size: 14px;">
                    <b>{{ $location->name }}</b><br>
                    <p>{{ $location->description }}</p><br>
                </div>
            `);
            marker._icon.id = 'marker-{{ $location->id }}';
        @endforeach
    </script>
</body>

</html>
