<?php
// Asegurar sesión iniciada (por si el controlador no lo hace)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variables que vienen del controlador (asumimos que están definidas)
$actividades = isset($actividades) ? $actividades : [];
$ubicacionUsuario = isset($ubicacionUsuario) ? $ubicacionUsuario : null;
$latUsuario = $ubicacionUsuario && !empty($ubicacionUsuario['UbicacionLatitud']) ? (float)$ubicacionUsuario['UbicacionLatitud'] : null;
$lngUsuario = $ubicacionUsuario && !empty($ubicacionUsuario['UbicacionLongitud']) ? (float)$ubicacionUsuario['UbicacionLongitud'] : null;
?>
<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unio | Explorar</title>
    <!-- Tailwind + Fuentes + Material Icons -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "outline": "#767777",
                        "inverse-surface": "#0c0f0f",
                        "primary-fixed-dim": "#9581ff",
                        "on-secondary": "#f9efff",
                        "tertiary-dim": "#8c2a5b",
                        "on-secondary-container": "#563098",
                        "on-error": "#ffefef",
                        "on-secondary-fixed-variant": "#603aa2",
                        "surface-container-lowest": "#ffffff",
                        "on-error-container": "#510017",
                        "background": "#f6f6f6",
                        "surface-tint": "#5a2af7",
                        "surface-container-high": "#e1e3e3",
                        "error-dim": "#a70138",
                        "primary-fixed": "#a292ff",
                        "outline-variant": "#acadad",
                        "primary": "#5a2af7",
                        "on-background": "#2d2f2f",
                        "secondary-fixed": "#ddc8ff",
                        "surface-container": "#e7e8e8",
                        "on-surface-variant": "#5a5c5c",
                        "on-tertiary": "#ffeff2",
                        "error-container": "#f74b6d",
                        "secondary-dim": "#5f39a1",
                        "surface-bright": "#f6f6f6",
                        "on-surface": "#2d2f2f",
                        "primary-dim": "#4e0bec",
                        "secondary-container": "#ddc8ff",
                        "error": "#b41340",
                        "secondary-fixed-dim": "#d2b8ff",
                        "surface-variant": "#dbdddd",
                        "on-primary-container": "#220076",
                        "on-primary-fixed": "#000000",
                        "on-tertiary-fixed": "#37001e",
                        "on-primary-fixed-variant": "#2b0090",
                        "on-tertiary-container": "#63033b",
                        "secondary": "#6b46ae",
                        "tertiary": "#9b3667",
                        "on-tertiary-fixed-variant": "#6f1044",
                        "surface-container-low": "#f0f1f1",
                        "tertiary-fixed-dim": "#f27db0",
                        "on-primary": "#f6f0ff",
                        "inverse-on-surface": "#9c9d9d",
                        "tertiary-container": "#ff8cbd",
                        "tertiary-fixed": "#ff8cbd",
                        "surface": "#f6f6f6",
                        "on-secondary-fixed": "#431783",
                        "inverse-primary": "#927dff",
                        "surface-container-highest": "#dbdddd",
                        "surface-dim": "#d3d5d5",
                        "primary-container": "#a292ff"
                    },
                    fontFamily: {
                        "headline": ["Plus Jakarta Sans"],
                        "body": ["Plus Jakarta Sans"],
                        "label": ["Plus Jakarta Sans"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .map-gradient-overlay {
            background: linear-gradient(to right, rgba(246, 246, 246, 0.9) 0%, rgba(246, 246, 246, 0) 40%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
        }
        /* Collapsible Sidebar Styles */
        #sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #sidebar.collapsed {
            width: 0;
            padding-left: 0;
            padding-right: 0;
            overflow: hidden;
            border-right-width: 0;
        }
        #sidebar.collapsed > div {
            opacity: 0;
            pointer-events: none;
        }
        #sidebar:not(.collapsed) > div {
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }
        #revealButton {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            pointer-events: none;
            opacity: 0;
            transform: translateX(-100%);
        }
        #sidebar.collapsed ~ #revealButton {
            pointer-events: auto;
            opacity: 1;
            transform: translateX(0);
        }
        /* Estilo para el marcador de usuario */
        .custom-div-icon {
            background: transparent;
            border: none;
        }
    </style>
    <!-- Leaflet CSS/JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-background text-on-surface h-screen">
    <!-- Top Navbar -->
    <header class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl shadow-[0_8px_32px_rgba(45,47,47,0.06)] h-16 px-8 flex justify-between items-center">
        <div class="flex items-center gap-8">
            <img src="Assets\Imgs\logo.png" alt="UNIO Logo" class="h-8 md:h-10 w-auto object-contain"/>
            <nav class="hidden md:flex gap-6">
                <a class="p-2 rounded-full text-[#5a2af7] font-bold transition-transform active:scale-95 inline-block" href="<?php echo BASE_URL; ?>">
                    Explorar
                </a>
                <a class="text-slate-500 font-medium hover:bg-slate-50 transition-colors duration-300 px-3 py-2 rounded-lg" href="<?php echo BASE_URL; ?>index.php?c=actividad&a=nueva">
                    Crear
                </a>
                <a class="text-slate-500 font-medium hover:bg-slate-50 transition-colors duration-300 px-3 py-2 rounded-lg" href="#">
                    Mis grupos
                </a>
            </nav>
        </div>
        <div class="relative group">
            <button class="flex items-center gap-2 px-3 py-2 rounded-full hover:bg-surface-container-high transition-colors">
                <span class="material-symbols-outlined">person</span>
                <span id="username" class="text-sm font-medium">
                    <?php 
                        if (isset($_SESSION['usuario_nombre'])) {
                            $partes = explode(' ', $_SESSION['usuario_nombre']);
                            echo htmlspecialchars($partes[0] . ' ' . ($partes[1] ?? ''));
                        } else {
                            echo 'Usuario';
                        }
                    ?>
                </span>
            </button>
            <div class="absolute right-0 top-full mt-2 w-56 bg-white/90 backdrop-blur-xl border border-outline-variant/10 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-[60] py-2">
                <a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-on-surface hover:bg-primary/5 hover:text-primary transition-colors" href="#">Mi perfil</a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-on-surface hover:bg-primary/5 hover:text-primary transition-colors">Notificaciones</a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-on-surface hover:bg-primary/5 hover:text-primary transition-colors">Ajustes</a>
                <a href="<?php echo BASE_URL; ?>index.php?c=login&a=logout" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-500 hover:bg-red-100 hover:text-red-600 transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-lg"></span>
                    <span>Cerrar sesión</span>
                </a>
            </div>
        </div>
    </header>

    <main class="relative pt-16 flex h-full">
        <!-- Sidebar (contenedor de lista de actividades) -->
        <aside class="relative h-full w-80 bg-[#f6f6f6] flex flex-col p-6 space-y-6 z-40 shrink-0 border-r border-outline-variant/20" id="sidebar">
            <div class="flex flex-col space-y-6 flex-1 min-w-[280px] overflow-y-auto">
                <!-- Header -->
                <div>
                    <h1 class="text-[1.75rem] font-bold text-on-surface leading-tight font-headline">Mi Comunidad</h1>
                    <p class="text-on-surface-variant text-sm mt-1">Explora y Conecta</p>
                </div>

                <!-- Intereses Cercanos (filtros estáticos, se pueden hacer dinámicos) -->
                <section class="space-y-3">
                    <h2 class="label-md font-bold uppercase tracking-widest text-outline">Intereses Cercanos</h2>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        $tipos = array_unique(array_column($actividades, 'TipoActividad'));
                        if (empty($tipos)) {
                            echo '<span class="px-4 py-2 rounded-full bg-surface-container-highest text-on-surface text-xs font-medium">Sin actividades aún</span>';
                        } else {
                            foreach ($tipos as $tipo) {
                                echo '<span class="px-4 py-2 rounded-full bg-surface-container-highest text-on-surface text-xs font-medium cursor-pointer hover:bg-surface-container-high transition-colors">' . htmlspecialchars($tipo) . '</span>';
                            }
                        }
                        ?>
                    </div>
                </section>

                <!-- Eventos para Ti (lista dinámica con actividades reales) -->
                <section class="flex-1 space-y-4 pr-2 overflow-y-auto">
                    <h2 class="label-md font-bold uppercase tracking-widest text-outline">Eventos para Ti</h2>
                    <?php if (empty($actividades)): ?>
                        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-sm text-center text-muted">
                            No hay actividades públicas disponibles en este momento.
                        </div>
                    <?php else: ?>
                        <?php foreach ($actividades as $act): ?>
                            <div class="bg-surface-container-lowest p-4 rounded-xl shadow-[0_4px_12px_rgba(45,47,47,0.04)] hover:translate-x-1 transition-all duration-300 cursor-pointer group"
                                data-actividad-id="<?php echo $act['idActividad']; ?>">
                                <div class="flex items-start gap-3">
                                    
                                    <div class="flex-1">
                                        <h3 class="font-bold text-on-surface group-hover:text-primary transition-colors">
                                            <?php echo htmlspecialchars($act['Nombre']); ?>
                                        </h3>
                                        <p class="text-xs text-on-surface-variant">
                                            <?php echo date('d/m/Y H:i', strtotime($act['FechaInicio'])); ?>
                                            <?php if (!empty($act['Direccion'])): ?>
                                                · <?php echo htmlspecialchars($act['Direccion']); ?>
                                            <?php endif; ?>
                                        </p>
                                        <div class="flex items-center mt-2 gap-1 text-[10px] text-primary font-bold">
                                            <span class="material-symbols-outlined text-sm">group</span>
                                            <span>Organiza: <?php echo htmlspecialchars($act['OrganizadorNombre'] . ' ' . $act['OrganizadorApellido']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>
            </div>

            <!-- Botón para colapsar sidebar -->
            <button class="absolute -right-5 top-1/2 -translate-y-1/2 w-10 h-16 bg-white border-2 border-primary/30 rounded-full shadow-[0_4px_20px_rgba(0,0,0,0.15)] flex items-center justify-center cursor-pointer z-50 hover:bg-primary hover:text-on-primary hover:border-primary transition-all duration-300 group" id="sidebarToggle" onclick="toggleSidebar()">
                <span class="material-symbols-outlined text-2xl font-bold" id="toggleIcon"><</span>
            </button>
        </aside>

        <!-- Botón flotante para revelar sidebar cuando está colapsada -->
        <button class="fixed left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/80 backdrop-blur-md rounded-xl shadow-xl border border-outline-variant/30 flex items-center justify-center z-50 text-primary hover:bg-primary hover:text-on-primary transition-all duration-300 active:scale-95" id="revealButton" onclick="toggleSidebar()">
            <span class="material-symbols-outlined text-2xl">></span>
        </button>

        <!-- Contenedor principal del mapa -->
        <div class="flex-1 relative bg-surface-container overflow-hidden">
            <div id="map" class="absolute inset-0 z-0"></div>

            <!-- Capa de interfaz flotante (controles, búsqueda, botones) -->
            <div class="absolute inset-0 z-10 pointer-events-none p-8 flex flex-col justify-between">
                <div class="flex justify-between items-start pointer-events-auto">
                    <div class="relative w-96">
                        <input class="w-full h-12 pl-12 pr-4 bg-white/90 backdrop-blur-md border-none rounded-2xl shadow-xl text-on-surface focus:ring-2 focus:ring-primary transition-all" placeholder="Buscar lugares o eventos..." type="text" id="search-input">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline"></span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <!-- Botón para actualizar ubicación (mismo id que usa la lógica original) -->
                        <button id="btn-actualizar-ubicacion" class="w-12 h-12 glass-card rounded-xl shadow-lg flex items-center justify-center text-on-surface active:scale-95 transition-transform">
                            <span class="material-symbols-outlined">my_location</span>
                        </button>
                        <button class="w-12 h-12 glass-card rounded-xl shadow-lg flex items-center justify-center text-on-surface active:scale-95 transition-transform">
                            <span class="material-symbols-outlined">layers</span>
                        </button>
                    </div>
                </div>

                <!-- FAB para crear actividad (grande en desktop) -->
                <div class="hidden md:flex justify-end pointer-events-auto">
                    <a href="<?php echo BASE_URL; ?>index.php?c=actividad&a=nueva" class="flex items-center gap-3 bg-primary text-on-primary px-8 py-4 rounded-full shadow-[0_8px_32px_rgba(90,42,247,0.4)] hover:shadow-[0_12px_48px_rgba(90,42,247,0.5)] active:scale-90 transition-all group">
                        <span class="font-bold text-lg">Crear actividad</span>
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center group-hover:rotate-90 transition-transform">
                            <span class="material-symbols-outlined"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Bottom Navbar (móvil) -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full flex justify-around items-center px-4 pt-3 pb-6 h-20 bg-white/70 backdrop-blur-xl border-t border-[#acadad]/20 shadow-[0_-8px_32px_rgba(45,47,47,0.06)] z-50 rounded-t-[1.5rem]">
        <a href="<?php echo BASE_URL; ?>" class="flex flex-col items-center justify-center bg-[#a292ff]/10 text-[#5a2af7] rounded-2xl px-4 py-1">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">explore</span>
            <span class="text-[10px] font-medium uppercase tracking-widest mt-1">Explorar</span>
        </a>
        <a href="<?php echo BASE_URL; ?>index.php?c=actividad&a=nueva" class="flex flex-col items-center justify-center text-[#2d2f2f] opacity-60">
            <span class="material-symbols-outlined">add_circle</span>
            <span class="text-[10px] font-medium uppercase tracking-widest mt-1">Crear</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center text-[#2d2f2f] opacity-60">
            <span class="material-symbols-outlined">chat</span>
            <span class="text-[10px] font-medium uppercase tracking-widest mt-1">Mis grupos</span>
        </a>
    </nav>

    <script>
        // ====================== FUNCIONALIDAD ORIGINAL ======================
        // Datos de actividades desde PHP
        const actividades = <?php echo json_encode($actividades, JSON_HEX_TAG); ?>;
        const latUsuario = <?php echo $latUsuario !== null ? $latUsuario : 'null'; ?>;
        const lngUsuario = <?php echo $lngUsuario !== null ? $lngUsuario : 'null'; ?>;

        // Centro y zoom inicial
        let centroMapa;
        let zoomInicial;
        if (latUsuario !== null && lngUsuario !== null) {
            centroMapa = [latUsuario, lngUsuario];
            zoomInicial = 13;
        } else {
            centroMapa = [19.4326, -99.1332]; // CDMX por defecto
            zoomInicial = 10;
        }

        // Inicializar mapa
        var map = L.map('map').setView(centroMapa, zoomInicial);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; CartoDB',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        // Almacenar marcadores
        const markers = {};

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Agregar marcadores de actividades
        actividades.forEach(act => {
            if (act.Latitud && act.Longitud) {
                const lat = parseFloat(act.Latitud);
                const lng = parseFloat(act.Longitud);
                const popupContent = `
                    <strong>${escapeHtml(act.Nombre)}</strong><br>
                    ${escapeHtml(act.TipoActividad)}<br>
                    Fecha: ${new Date(act.FechaInicio).toLocaleDateString()}<br>
                    Organizador: ${escapeHtml(act.OrganizadorNombre)} ${escapeHtml(act.OrganizadorApellido)}<br>
                    ${act.Direccion ? `<i class="material-symbols-outlined" style="font-size:14px">pin_drop</i> ${escapeHtml(act.Direccion)}` : ''}
                `;
                const marker = L.marker([lat, lng]).addTo(map).bindPopup(popupContent);
                markers[act.idActividad] = marker;
            }
        });

        // Marcador de ubicación del usuario (si existe en BD)
        let userMarker = null;
        if (latUsuario !== null && lngUsuario !== null) {
            const iconoUsuario = L.divIcon({
                className: 'custom-div-icon',
                html: '<div style="background-color: #5a2af7; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 4px rgba(0,0,0,0.3);"></div>',
                iconSize: [20, 20],
                popupAnchor: [0, -10]
            });
            userMarker = L.marker([latUsuario, lngUsuario], { icon: iconoUsuario }).addTo(map)
                .bindPopup('<strong>Tu ubicación</strong><br>Basada en tu perfil.');
        }

        // Click en elementos de la lista (sidebar) para centrar mapa y abrir popup
        document.querySelectorAll('[data-actividad-id]').forEach(item => {
            item.addEventListener('click', () => {
                const id = item.getAttribute('data-actividad-id');
                const actividad = actividades.find(a => a.idActividad == id);
                if (actividad && actividad.Latitud && actividad.Longitud) {
                    const lat = parseFloat(actividad.Latitud);
                    const lng = parseFloat(actividad.Longitud);
                    map.setView([lat, lng], 15);
                    if (markers[id]) markers[id].openPopup();
                }
            });
        });

        // Actualizar ubicación vía geolocation
        function actualizarUbicacion() { 
            if (!navigator.geolocation) {
                alert('Geolocalización no soportada por tu navegador.');
                return;
            }
            const btn = document.getElementById('btn-actualizar-ubicacion');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span>';
            btn.disabled = true;

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    fetch('<?php echo BASE_URL; ?>index.php?c=dashboard&a=actualizarUbicacion', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ latitud: lat, longitud: lng })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (userMarker) map.removeLayer(userMarker);
                            userMarker = L.circleMarker([lat, lng], {
                                radius: 8,
                                color: '#5a2af7',
                                fillColor: '#a292ff',
                                fillOpacity: 0.8,
                                weight: 2
                            }).addTo(map).bindPopup('<strong>Tu ubicación actual</strong><br>Actualizada correctamente.').openPopup();
                            map.setView([lat, lng], 13);

                            // Mostrar mensaje temporal
                            let estadoDiv = document.getElementById('estado-ubicacion');
                            if (!estadoDiv) {
                                estadoDiv = document.createElement('div');
                                estadoDiv.id = 'estado-ubicacion';
                                estadoDiv.className = 'fixed bottom-4 left-4 z-50 bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow-lg';
                                document.body.appendChild(estadoDiv);
                            }
                            estadoDiv.innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span> Ubicación actualizada.';
                            estadoDiv.style.display = 'block';
                            setTimeout(() => estadoDiv.style.display = 'none', 3000);
                        } else {
                            alert('Error al actualizar: ' + (data.error || 'desconocido'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error de comunicación con el servidor.');
                    })
                    .finally(() => {
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                    });
                },
                (error) => {
                    let msg = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED: msg = 'Permiso denegado. Activa la ubicación en tu navegador.'; break;
                        case error.POSITION_UNAVAILABLE: msg = 'Información de ubicación no disponible.'; break;
                        case error.TIMEOUT: msg = 'Tiempo de espera agotado.'; break;
                        default: msg = 'Error desconocido al obtener la ubicación.';
                    }
                    alert(msg);
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                }
            );
        }

        // Asignar evento al botón de actualizar ubicación
        const ubicacionBtn = document.getElementById('btn-actualizar-ubicacion');
        if (ubicacionBtn) ubicacionBtn.addEventListener('click', actualizarUbicacion);

        // ====================== FUNCIONALIDAD DEL SIDEBAR ======================
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggleIcon = document.getElementById('toggleIcon');
            sidebar.classList.toggle('collapsed');
            toggleIcon.innerText = sidebar.classList.contains('collapsed') ? '>' : '<';
        }
    </script>
</body>
</html>