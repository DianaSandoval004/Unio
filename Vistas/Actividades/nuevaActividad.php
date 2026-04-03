<?php
$tipos = isset($tipos) ? $tipos : [];
$errores = isset($errores) ? $errores : [];
$old = isset($old) ? $old : [];
?>

<!DOCTYPE html>

<html class="light" lang="es">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>Unio | Crear actividad</title>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
        
        <script id="tailwind-config">
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
                    "surface-tint": "#6236FF",
                    "surface-container-high": "#e1e3e3",
                    "error-dim": "#a70138",
                    "primary-fixed": "#a292ff",
                    "outline-variant": "#acadad",
                    "primary": "#6236FF",
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
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "0.75rem", "xl": "1rem", "full": "9999px"},
                },
                },
            }
        </script>

        <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        </style>
    </head>

    <body class="bg-background text-on-surface min-h-screen">
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-outline-variant/10 px-4 md:px-8 py-4">
            <div class="max-w-7xl mx-auto flex items-center">
                <img alt="UNIO Logo" class="h-8 md:h-10 w-auto object-contain" src="Assets/Imgs/logo.png"/>
            </div>
        </nav>
        <!-- Top Navigation Bar -->

        <!-- Main Content Canvas -->
        <main class="pb-32 px-4 md:px-8 max-w-4xl mx-auto pt-12">

            <!-- Header -->
            <div class="mb-12 text-center md:text-left flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-[3.5rem] font-extrabold tracking-tight leading-tight text-on-surface mb-2 font-headline">
                        Crear actividad
                    </h1>
                    <p class="text-body-lg text-on-surface-variant max-w-xl">
                        Diseña una experiencia única para tu comunidad.
                        <br>
                        Fecha de publicación:
                        <span class="font-bold"><?php echo date('d M, Y'); ?></span>
                    </p>
                </div>
            </div>

            <!-- Errores -->
            <?php if (!empty($errores)): ?>
                <div class="mb-6 p-4 rounded-xl bg-red-100 text-red-700">
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="index.php?c=actividad&a=guardar" method="POST">

                <div class="grid grid-cols-1 gap-8">
                    <!-- Sección: Imagen actividad -->
                    <section class="bg-surface-container-lowest p-8 rounded-xl shadow space-y-6">
                        <div class="md:col-span-2 space-y-4">
                            <label class="block font-medium text-sm uppercase tracking-widest text-on-surface-variant font-label">
                            Imagen de la actividad
                            </label>
                            <div class="aspect-video w-full bg-surface-container-low rounded-xl border-2 border-dashed border-outline-variant flex flex-col items-center justify-center cursor-pointer hover:border-primary/40 transition-colors group">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant group-hover:text-primary transition-colors">
                                add_photo_alternate
                            </span>
                            <p class="mt-2 text-sm text-on-surface-variant">
                                Sube una imagen para ilustrar tu actividad
                            </p>
                            </div>
                        </div>
                    </section>

                    <!-- Sección: Nombre y tipo -->
                    <section class="bg-surface-container-lowest p-8 rounded-xl shadow space-y-6">
                        <!-- Nombre de la actividad -->
                        <div class="space-y-2">
                            <label class="block font-medium text-sm uppercase tracking-widest text-on-surface-variant font-label">
                                Nombre de la actividad
                            </label>
                            <input type="text" name="nombre"
                                value="<?php echo htmlspecialchars($old['nombre'] ?? ''); ?>"
                                required
                                class="w-full h-14 px-5 bg-surface-container-low rounded-xl"
                                placeholder="Ej: Clase magistral">
                        </div>
                        <!-- Clasificación de la actividad -->
                        <div class="space-y-2">
                            <label class="block font-medium text-sm uppercase tracking-widest text-on-surface-variant font-label">
                                Clasificación
                            </label>
                            <select name="tipo_actividad" required class="w-full h-12 px-4 bg-surface-container-low rounded-xl">
                                <option value="">Seleccione...</option>
                                <?php foreach ($tipos as $tipo): ?>
                                    <option value="<?php echo $tipo['idTipoActividad']; ?>"
                                        <?php echo (isset($old['tipo_actividad']) && $old['tipo_actividad'] == $tipo['idTipoActividad']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($tipo['Nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                                <!-- Tipos de actividades:
                                Creativa y artística
                                Bienestar y relajación
                                Al aire libre y con la naturaleza
                                Turismo y exploración
                                Gastronómica
                                Social y comunitaria
                                Física y deportiva
                                Entretenimiento y ocio
                                Intelectual y cultural
                                -->
                        </div>
                    </section>

                    <!-- Participantes y edades -->
                    <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Límite de Participantes -->
                        <div class="bg-surface-container-lowest p-8 rounded-xl shadow space-y-4">
                            <label class="block font-medium text-sm uppercase tracking-widest text-on-surface-variant font-label">
                                Participantes
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <!-- Cantidad mínima -->
                                    <span class="text-xs text-on-surface-variant font-medium">
                                        Mínimo
                                    </span>
                                    <input type="number" name="min_participantes"
                                        value="<?php echo htmlspecialchars($old['min_participantes'] ?? 1); ?>"
                                        class="w-full h-12 px-4 bg-surface-container-low rounded-lg"
                                        placeholder="Mínimo">
                                </div>
                                <div class="space-y-2">
                                    <span class="text-xs text-on-surface-variant font-medium">
                                        Máximo
                                    </span>
                                    <!--  Cantidad máxima -->
                                    <input type="number" name="max_participantes"
                                        value="<?php echo htmlspecialchars($old['max_participantes'] ?? ''); ?>"
                                        class="w-full h-12 px-4 bg-surface-container-low rounded-lg"
                                        placeholder="Ilimitado">
                                </div>
                            </div>
                        </div>
                        <!-- Rango de edad -->
                        <div class="bg-surface-container-lowest p-8 rounded-xl shadow space-y-4">
                            <label class="block font-medium text-sm uppercase tracking-widest text-on-surface-variant font-label">
                                Edad
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <!-- Edad mínima -->
                                    <span class="text-xs text-on-surface-variant font-medium">
                                        Mínima
                                    </span>
                                    <input type="number" name="edad_min"
                                        value="<?php echo htmlspecialchars($old['edad_min'] ?? ''); ?>"
                                        class="w-full h-12 px-4 bg-surface-container-low rounded-lg"
                                        placeholder="Edad mínima">
                                </div>
                                <div class="space-y-2">
                                    <span class="text-xs text-on-surface-variant font-medium">
                                        Máxima
                                    </span>
                                    <!-- Edad máxima -->
                                    <input type="number" name="edad_max"
                                        value="<?php echo htmlspecialchars($old['edad_max'] ?? ''); ?>"
                                        class="w-full h-12 px-4 bg-surface-container-low rounded-lg"
                                        placeholder="Edad máxima">
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Fechas -->
                    <section class="bg-surface-container-lowest p-8 rounded-xl shadow space-y-6">
                        <label class="block font-medium text-sm uppercase tracking-widest text-on-surface-variant font-label">
                            Fechas
                        </label>
                        <!-- Día y Horarios -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- INICIO -->
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-primary">INICIO</span>
                                <input type="datetime-local" name="fecha_inicio"
                                    value="<?php echo htmlspecialchars($old['fecha_inicio'] ?? ''); ?>"
                                    required
                                    class="w-full h-12 px-4 bg-surface-container-low rounded-lg">
                            </div>
                            <!-- FIN -->
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-primary">FIN</span>
                                <input type="datetime-local" name="fecha_fin"
                                    value="<?php echo htmlspecialchars($old['fecha_fin'] ?? ''); ?>"
                                    required
                                    class="w-full h-12 px-4 bg-surface-container-low rounded-lg">
                            </div>
                        </div>
                    </section>
                    
                    <!-- Ubicación -->
                    <section class="bg-surface-container-lowest p-8 rounded-xl shadow space-y-4">
                        <label class="block font-medium text-sm uppercase tracking-widest text-on-surface-variant font-label">
                            Ubicación
                        </label>
                        <!-- Mapa -->
                        <div id="map" style="height:300px;" class="rounded-xl"></div>
                        <input type="text" name="direccion"
                            value="<?php echo htmlspecialchars($old['direccion'] ?? ''); ?>"
                            class="w-full h-12 px-4 bg-surface-container-low rounded-lg"
                            placeholder="Dirección">
                            
                        <!-- Dirección capturada -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Latitud -->
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-primary">
                                    LATITUD
                                </span>
                                <input type="text" name="latitud" id="latitud" readonly
                                    value="<?php echo htmlspecialchars($old['latitud'] ?? ''); ?>"
                                    class="w-full h-12 px-4 bg-surface-container-low rounded-lg">
                            </div>
                            <!-- Longitud -->
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-primary">
                                    LONGITUD
                                </span>
                                <input type="text" name="longitud" id="longitud" readonly
                                    value="<?php echo htmlspecialchars($old['longitud'] ?? ''); ?>"
                                    class="w-full h-12 px-4 bg-surface-container-low rounded-lg">
                            </div>
                        </div>
                    </section>

                    <!-- Descripción y privacidad -->
                    <section class="bg-surface-container-lowest p-8 rounded-xl shadow space-y-6">
                        <!-- Descripción actividad -->
                        <textarea name="descripcion"
                            class="w-full p-4 bg-surface-container-low rounded-xl"
                            placeholder="Descripción"><?php echo htmlspecialchars($old['descripcion'] ?? ''); ?></textarea>
                        <!-- Tipo de acceso -->
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="acceso_publico" value="1"
                                <?php echo (isset($old['acceso_publico']) && $old['acceso_publico'] == '1') ? 'checked' : 'checked'; ?>>
                                <span class="material-symbols-outlined">public</span>
                                <span>Acceso público</span>
                        </label>
                    </section>

                    <!-- Botones -->
                    <div class="flex justify-end gap-4">
                        <a href="index.php?c=dashboard"
                            class="px-6 py-3 rounded-xl bg-gray-200">
                            Cancelar
                        </a>
                        <!-- Botón para crear actividad -->
                        <button type="submit"
                            class="px-8 py-3 rounded-xl bg-primary text-white">
                            Crear actividad
                        </button>

                    </div>
                </div>
            </form>
        </main>


    <!-- Leaflet CSS y JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Inicializar mapa centrado en México (CDMX) o en la ubicación del usuario si está disponible
        let latInicial = <?php echo isset($old['latitud']) && !empty($old['latitud']) ? $old['latitud'] : '19.4326'; ?>;
        let lngInicial = <?php echo isset($old['longitud']) && !empty($old['longitud']) ? $old['longitud'] : '-99.1332'; ?>;
        let zoomInicial = 13;

        var map = L.map('map').setView([latInicial, lngInicial], zoomInicial);

        // Capa base
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; CartoDB',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        // Marcador inicial (si hay coordenadas guardadas)
        let marker = null;
        if (latInicial && lngInicial && latInicial != 19.4326 && lngInicial != -99.1332) {
            marker = L.marker([latInicial, lngInicial]).addTo(map)
                .bindPopup('Ubicación seleccionada').openPopup();
        }

        // Función para actualizar campos cuando se hace clic en el mapa
        function onMapClick(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            document.getElementById('latitud').value = lat;
            document.getElementById('longitud').value = lng;
            // Si se desea obtener dirección aproximada, se puede usar una API de geocodificación
            // Por ahora solo lat/lng

            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map)
                .bindPopup('Ubicación seleccionada').openPopup();
        }

        map.on('click', onMapClick);

        // Si el usuario ya tiene ubicación guardada en sesión, podríamos centrar el mapa allí
        // (opcional, se puede usar la ubicación del usuario desde PHP si se pasa)
        <?php if (isset($_SESSION['usuario_id'])): ?>
            // Obtener ubicación del usuario para centrar el mapa inicialmente
            // Podríamos pasar latUsuario y lngUsuario desde el controlador a la vista
        <?php endif; ?>
    </script>

    </body>
</html>
