<div class="sidebar">
    <h2>Menu</h2>


    <div class="menu-section">
        <button onclick="resetMap()" class="menu-button">Map</button>
    </div>

    <!-- Menu Lokasi -->
    <div class="menu-section">
        <button onclick="toggleMenu('location-menu')" class="menu-button">Lokasi</button>
        <div id="location-menu" class="menu-content" style="display: none;">
            @foreach ($locations as $location)
                <div class="location-item">
                    <a href="#marker-{{ $location->id }}" class="menu-link">{{ $location->name }}</a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Menu Polyline -->
    <div class="menu-section">
        <button onclick="toggleMenu('polyline-menu')" class="menu-button">Polyline</button>
        <div id="polyline-menu" class="menu-content" style="display: none;">
            <button onclick="drawPolyline()" class="menu-item">
                Draw Polyline
            </button>
        </div>
    </div>

    <script>
        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            // Toggle antara menampilkan dan menyembunyikan
            if (menu.style.display === "none") {
                menu.style.display = "block";
            } else {
                menu.style.display = "none";
            }
        }

        function drawPolyline() {
            // Implement polyline drawing functionality
            alert('Polyline drawing functionality to be implemented.');
        }
    </script>

    <!-- Menu Polygon -->
    <div class="menu-section">
        <button onclick="toggleMenu('polygon-menu')" class="menu-button">Polygon</button>
        <div id="polygon-menu" class="menu-content" style="display: none;">
            <button onclick="drawPolygon()" class="menu-item">
                Draw Polygon
            </button>
        </div>
    </div>
    <script>
        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            // Toggle antara menampilkan dan menyembunyikan
            if (menu.style.display === "none") {
                menu.style.display = "block";
            } else {
                menu.style.display = "none";
            }
        }
        function drawPolygon() {
            // Implement polygon drawing functionality
            alert('Polygon drawing functionality to be implemented.');
        }
    </script>
</div>
