<style>
    .sidebar {
        padding: 20px;
        background-color: #e6f7ff;
        width: 250px;
        border-right: 1px solid #ccc;
    }

    .menu-section {
        margin-bottom: 20px;
    }

    .menu-button-box {
        display: inline-block;
        width: 100%;
        padding: 15px;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #0f0f0f 0%, #faf8f8 100%);
        color: white;
        text-align: center;
        border-radius: 8px;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
        box-sizing: border-box;
    }

    .menu-button-box:hover {
        background: linear-gradient(135deg, #FF5722 0%, #38B6FF 100%);
        transform: translateY(-3px);
        cursor: pointer;
    }

    .menu-link {
        color: #38B6FF;
        text-decoration: none;
        display: block;
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
        background-color: #f0f0f0;
    }

    .menu-link:hover {
        text-decoration: underline;
        background-color: #e0e0e0;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #ff5938;
        color: white;
    }

    .menu-content {
        padding: 10px 0;
    }
    select {
        width: 100%;
        padding: 15px;
        border-radius: 8px;
        border: none;
        background-color: #007bff;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
    }

    select option {
        background-color: #868383;
        color: #fff;
    }
</style>

<div class="sidebar">
    <h2>Menu</h2>

   <!-- Button to Reset Map -->
   <div class="menu-section">
    <button onclick="resetMap()" class="menu-button-box">New Map</button>
    </div>

    <!-- Button to Add New Location -->
    <div class="menu-section">
        <a href="{{ route('locations.create') }}" class="menu-button-box">Insert File</a>
    </div>

    <!-- Button to Download All Locations as JSON -->
    <div class="menu-section">
        <a href="{{ route('locations.exportAllJson') }}" class="menu-button-box">Download as JSON</a>
    </div>


   <!-- Layer Selection Dropdown -->
   <div class="menu-section">
    <button class="menu-button-box" onclick="toggleDropdown()">Choose Map</button>
    <select id="layer-selector" class="menu-button-box" onchange="changeBaseMap(this.value)">
        <option value="osm" selected>OpenStreetMap</option>
        <option value="satelliteMap">Topography</option>
        <option value="googleSat">Google Satellite</option>
    </select>
</div>

<div class="menu-section">
    <button class="menu-button-box" onclick="toggleSavedLayers()">Select Saved Layer</button>
    <div id="saved-layers-dropdown" class="dropdown-content" style="display: none;">
        <select id="saved-layers-selector" class="menu-button-box" onchange="changeSavedLayer(this.value)">
            <option value="">Select Layer</option>
        </select>
    </div>
</div>


</div>

    <script>
    function toggleDropdown() {
        const dropdown = document.getElementById('layer-selector');
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    }

    function toggleSavedLayers() {
    const dropdown = document.getElementById("saved-layers-dropdown");
    dropdown.style.display = dropdown.style.display === "none" || dropdown.style.display === "" ? "block" : "none";
}

function changeSavedLayer(value) {
    // Logika untuk mengubah layer peta
    console.log("Selected layer:", value);
    // Tambahkan logika untuk mengubah layer peta sesuai value
}

    // Menyembunyikan dropdown saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('layer-selector').style.display = 'none';
    });

    // Fetch saved layers from the server
    fetch("{{ route('locations.getSavedPolygons') }}")
    .then(response => response.json())
    .then(locations => {
        const selector = document.getElementById('saved-layers-selector');
        locations.forEach(location => {
            const option = document.createElement('option');
            option.value = location.id; // Assuming `id` is the identifier
            option.textContent = location.name; // Assuming `name` is the display name
            selector.appendChild(option);
        });
    })
    .catch(error => console.error('Error fetching saved layers:', error));


    document.getElementById('saved-layers-selector').addEventListener('change', function() {
    const selectedId = this.value;

    if (selectedId) {
        // Clear previous polygons
        drawnItems.clearLayers();

        // Fetch the selected layer's polygon data
        fetch(`{{ url('/locations/') }}/${selectedId}`) // Assuming you have a route to get a specific location
            .then(response => response.json())
            .then(location => {
                if (location.polygon) {
                    const polygonData = JSON.parse(location.polygon);
                    const polygonLayer = L.geoJSON(polygonData, {
                        style: {
                            color: getRandomColor(),
                            fillOpacity: 0.5,
                            weight: 2
                        }
                    }).addTo(drawnItems);
                    polygonLayer.bindPopup(`<b>${location.name}</b><br>${location.description}`);
                } else {
                    alert('No polygon data available for this location.');
                }
            })
            .catch(error => console.error('Error fetching polygon data:', error));
    }
});


</script>
