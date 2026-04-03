<?php

// Definir BASE_URL si no está definida (ajusta según tu estructura)
if (!defined('BASE_URL')) {
    define('BASE_URL', '/'); // Cambia por la ruta base de tu proyecto
}

// Capturar errores desde el controlador o desde la misma página
// Suponemos que $errores viene del controlador (por ejemplo, al validar el formulario)
$errores = isset($errores) ? $errores : [];
?>
<!DOCTYPE html>
<html class="light" lang="es">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>UNIO - Registro</title>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "on-primary-fixed-variant": "#2b0090",
                            "on-tertiary-fixed": "#37001e",
                            "on-primary-fixed": "#000000",
                            "surface-container-lowest": "#ffffff",
                            "surface-tint": "#5a2af7",
                            "on-tertiary": "#ffeff2",
                            "inverse-on-surface": "#9c9d9d",
                            "on-secondary-container": "#563098",
                            "tertiary-container": "#ff8cbd",
                            "on-secondary-fixed": "#431783",
                            "primary-fixed": "#a292ff",
                            "on-background": "#2d2f2f",
                            "outline-variant": "#acadad",
                            "inverse-surface": "#0c0f0f",
                            "secondary-fixed-dim": "#d2b8ff",
                            "primary-fixed-dim": "#9581ff",
                            "on-primary": "#f6f0ff",
                            "on-error": "#ffefef",
                            "tertiary": "#9b3667",
                            "on-surface": "#2d2f2f",
                            "on-primary-container": "#220076",
                            "surface-container-low": "#f0f1f1",
                            "error-container": "#f74b6d",
                            "error": "#b41340",
                            "surface-variant": "#dbdddd",
                            "error-dim": "#a70138",
                            "surface-dim": "#d3d5d5",
                            "secondary-container": "#ddc8ff",
                            "on-secondary": "#f9efff",
                            "background": "#f6f6f6",
                            "primary": "#5a2af7",
                            "on-tertiary-fixed-variant": "#6f1044",
                            "primary-dim": "#4e0bec",
                            "primary-container": "#a292ff",
                            "secondary-fixed": "#ddc8ff",
                            "surface-container-highest": "#dbdddd",
                            "tertiary-dim": "#8c2a5b",
                            "tertiary-fixed-dim": "#f27db0",
                            "surface-container": "#e7e8e8",
                            "outline": "#767777",
                            "surface-container-high": "#e1e3e3",
                            "tertiary-fixed": "#ff8cbd",
                            "on-surface-variant": "#5a5c5c",
                            "secondary-dim": "#5f39a1",
                            "surface-bright": "#f6f6f6",
                            "surface": "#f6f6f6",
                            "on-tertiary-container": "#63033b",
                            "inverse-primary": "#927dff",
                            "on-error-container": "#510017",
                            "secondary": "#6b46ae",
                            "on-secondary-fixed-variant": "#603aa2"
                        },
                        fontFamily: {
                            "headline": ["Plus Jakarta Sans"],
                            "body": ["Plus Jakarta Sans"],
                            "label": ["Plus Jakarta Sans"]
                        },
                        borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                    },
                },
            }
        </script>
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
            .kinetic-gradient {
                background: linear-gradient(135deg, #5a2af7 0%, #a292ff 100%);
            }
            .glass-panel {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(20px);
            }
            input[type="date"]::-webkit-calendar-picker-indicator {
                filter: invert(0.5);
                cursor: pointer;
            }
            /* Estilos para el campo de archivo personalizado */
            .file-input-label {
                cursor: pointer;
                transition: all 0.2s;
            }
            .file-input-label:hover {
                background-color: #eef2ff;
            }
        </style>
    </head>
    <body class="bg-background text-on-surface min-h-screen flex flex-col">
        <main class="flex-grow flex items-center justify-center p-6 md:p-12 relative overflow-hidden">
            <!-- Background Refraction Elements -->
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/5 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-tertiary/5 rounded-full blur-[100px]"></div>
            <div class="w-full max-w-4xl grid grid-cols-1 lg:grid-cols-12 gap-0 shadow-2xl shadow-on-surface/5 rounded-3xl overflow-hidden bg-surface-container-lowest">
                <!-- Left Side: Aesthetic/Branding -->
                <div class="hidden lg:flex lg:col-span-5 kinetic-gradient p-12 flex-col justify-between relative overflow-hidden">
                    <div class="relative z-10">
                        <img alt="UNIO Logo" class="h-10 w-auto mb-8 brightness-0 invert mx-auto block" src="Assets\Imgs\logo.png">
                        <h2 class="text-white text-4xl font-extrabold tracking-tighter leading-tight">
                            Únete a la nueva era de eventos.
                        </h2>
                        <p class="text-white/80 mt-6 text-lg font-light leading-relaxed">
                            Gestiona, descubre y conecta en un solo lugar diseñado para la fluidez y la eficiencia.
                        </p>
                    </div>
                    <!-- Decorative Prism Shape -->
                    <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                </div>

                <!-- Right Side: Registration Form -->
                <div class="lg:col-span-7 p-8 md:p-12 lg:p-16">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex justify-center mb-8">
                        <img alt="UNIO Logo" class="h-8 w-auto" src="Assets\Imgs\logo.png">
                    </div>

                    <div class="mb-10 text-center lg:text-left">
                        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-on-surface mb-2">Crea tu cuenta</h1>
                        <p class="text-on-surface-variant text-lg">Completa los datos para comenzar tu experiencia.</p>
                    </div>

                    <!-- Mostrar errores si existen -->
                    <?php if (!empty($errores)): ?>
                        <div class="bg-error-container/20 border-l-4 border-error text-on-error-container p-4 rounded-md mb-6">
                            <ul class="list-disc pl-5 space-y-1 text-sm">
                                <?php foreach ($errores as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>?c=registro&a=registrar" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <!-- Nombre y Apodo -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="nombre" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Nombre completo</label>
                                <input type="text" id="nombre" name="nombre" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface placeholder:text-outline/50" placeholder="Ej. Juan Ignacio" required>
                            </div>
                            <div class="space-y-2">
                                <label for="apodo" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Apodo</label>
                                <input type="text" id="apodo" name="apodo" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface placeholder:text-outline/50" placeholder="Cómo te llaman">
                            </div>
                        </div>

                        <!-- Apellidos -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="apellido_paterno" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Apellido paterno</label>
                                <input type="text" id="apellido_paterno" name="apellido_paterno" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface placeholder:text-outline/50" placeholder="Apellido paterno" required>
                            </div>
                            <div class="space-y-2">
                                <label for="apellido_materno" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Apellido materno</label>
                                <input type="text" id="apellido_materno" name="apellido_materno" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface placeholder:text-outline/50" placeholder="Apellido materno">
                            </div>
                        </div>

                        <!-- Género, Fecha, Teléfono -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="genero" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Género</label>
                                <div class="relative">
                                    <select id="genero" name="genero" class="w-full appearance-none bg-none px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface pr-10 cursor-pointer">
                                        <option value="">Seleccionar</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otro">Otro</option>
                                        <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">
                                        <span class="material-symbols-outlined text-xl">expand_more</span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="telefono" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Teléfono</label>
                                <input type="tel" id="telefono" name="telefono" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface placeholder:text-outline/50" placeholder="+52 288 000 00 00">
                            </div>
                        </div>

                        <!-- Fecha de nacimiento -->
                        <div class="space-y-2">
                            <label for="fecha_nacimiento" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Fecha de Nacimiento</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface" required>
                        </div>

                        <!-- Correo -->
                        <div class="space-y-2">
                            <label for="correo" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Correo electrónico</label>
                            <input type="email" id="correo" name="correo" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface placeholder:text-outline/50" placeholder="tu@correo.com" required>
                        </div>

                        <!-- Contraseña y Confirmación -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="password" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Contraseña</label>
                                <input type="password" id="password" name="password" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface placeholder:text-outline/50" placeholder="••••••••" required minlength="6">
                            </div>
                            <div class="space-y-2">
                                <label for="confirmar_password" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Confirmar contraseña</label>
                                <input type="password" id="confirmar_password" name="confirmar_password" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface placeholder:text-outline/50" placeholder="••••••••" required minlength="6">
                            </div>
                        </div>

                        <!-- Biografía -->
                        <div class="space-y-2">
                            <label for="biografia" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Biografía</label>
                            <textarea id="biografia" name="biografia" rows="3" class="w-full px-5 py-4 rounded-xl border-none bg-surface-container-low focus:ring-2 focus:ring-primary/20 transition-all text-on-surface placeholder:text-outline/50" placeholder="Cuéntanos un poco sobre ti..."></textarea>
                        </div>

                        <!-- Foto de perfil -->
                        <div class="space-y-2">
                            <label for="foto_perfil" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Foto de perfil</label>
                            <div class="flex items-center gap-3">
                                <label for="foto_perfil" class="file-input-label px-5 py-3 rounded-xl bg-surface-container-high text-on-surface-variant hover:bg-primary/10 transition-colors cursor-pointer text-sm font-medium">
                                    <span class="material-symbols-outlined align-middle mr-1 text-base">cloud_upload</span>
                                    Seleccionar archivo
                                </label>
                                <span id="nombre_archivo" class="text-sm text-on-surface-variant">Ningún archivo seleccionado</span>
                            </div>
                            <input type="file" id="foto_perfil" name="foto_perfil" accept="image/jpeg,image/png,image/gif" class="hidden">
                            <small class="text-on-surface-variant text-xs mt-1 block">Formatos permitidos: JPG, PNG, GIF. Máximo 16MB.</small>
                        </div>

                        <!-- Ubicación actual -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Ubicación actual</label>
                            <button type="button" id="btn-ubicacion" class="px-5 py-3 rounded-xl bg-surface-container-high text-on-surface-variant hover:bg-primary/10 transition-colors text-sm font-medium flex items-center gap-2">
                                <span class="material-symbols-outlined text-base">my_location</span>
                                Obtener ubicación
                            </button>
                            <div id="estado-ubicacion" class="text-sm text-on-surface-variant mt-2"></div>
                            <input type="hidden" name="latitud" id="latitud" value="">
                            <input type="hidden" name="longitud" id="longitud" value="">
                        </div>

                        <!-- Términos y condiciones -->
                        <div class="space-y-4 pt-2">
                            <div class="flex items-start gap-3">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" id="terminos" name="terminos" class="w-5 h-5 rounded border-outline-variant bg-surface-container text-primary focus:ring-primary/20" required>
                                </div>
                                <label for="terminos" class="text-sm text-on-surface-variant leading-relaxed">
                                    Acepto los <a href="#" class="text-primary font-semibold hover:underline">términos de servicio</a> y la <a href="#" class="text-primary font-semibold hover:underline">política de privacidad</a>.
                                </label>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" id="ubicacion_consentimiento" name="ubicacion_consentimiento" class="w-5 h-5 rounded border-outline-variant bg-surface-container text-primary focus:ring-primary/20">
                                </div>
                                <label for="ubicacion_consentimiento" class="text-sm text-on-surface-variant leading-relaxed">
                                    Permitir acceso a mi ubicación actual.
                                    <span class="block text-xs opacity-70 mt-0.5">Esto es necesario para el correcto funcionamiento de la funcionalidad de mapas.</span>
                                </label>
                            </div>
                        </div>

                        <!-- Botón de registro -->
                        <div class="pt-4">
                            <button type="submit" class="w-full kinetic-gradient text-white font-bold py-5 rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:scale-[1.01] transition-all active:scale-[0.98] text-lg">
                                Crear cuenta
                            </button>
                        </div>

                        <!-- Enlace a login -->
                        <div class="text-center pt-6">
                            <p class="text-on-surface-variant font-medium">
                                ¿Ya tienes una cuenta?
                                <a href="<?php echo BASE_URL; ?>?c=login" class="text-primary font-bold hover:underline ml-1">Iniciar Sesión</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full border-t border-outline-variant/10 py-6 px-12 flex flex-col md:flex-row justify-between items-center gap-4 bg-surface-container-lowest">
            <div class="text-sm font-['Plus_Jakarta_Sans'] text-slate-500">
                © 2026 UNIO - Conectando con la realidad. Todos los derechos reservados.
            </div>
            <div class="flex gap-6">
                <a class="text-sm text-slate-500 hover:text-primary transition-colors" href="#">Privacidad</a>
                <a class="text-sm text-slate-500 hover:text-primary transition-colors" href="#">Términos</a>
                <a class="text-sm text-slate-500 hover:text-primary transition-colors" href="#">Ayuda</a>
            </div>
        </footer>

        <!-- Scripts para geolocalización y feedback de archivo -->
        <script>
            // Mostrar nombre del archivo seleccionado
            const fileInput = document.getElementById('foto_perfil');
            const fileNameSpan = document.getElementById('nombre_archivo');
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    fileNameSpan.textContent = this.files[0].name;
                } else {
                    fileNameSpan.textContent = 'Ningún archivo seleccionado';
                }
            });

            // Geolocalización
            const btnUbicacion = document.getElementById('btn-ubicacion');
            const estadoUbicacion = document.getElementById('estado-ubicacion');
            const latInput = document.getElementById('latitud');
            const lngInput = document.getElementById('longitud');

            btnUbicacion.addEventListener('click', () => {
                if (!navigator.geolocation) {
                    estadoUbicacion.innerHTML = '<span class="text-error">Geolocalización no soportada por este navegador.</span>';
                    return;
                }

                estadoUbicacion.innerHTML = '<span class="text-on-surface-variant">Obteniendo ubicación...</span>';

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        latInput.value = lat;
                        lngInput.value = lng;
                        estadoUbicacion.innerHTML = `<span class="text-green-600">Ubicación obtenida: ${lat.toFixed(6)}, ${lng.toFixed(6)}</span>`;
                    },
                    (error) => {
                        let mensaje = '';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                mensaje = 'Permiso denegado. Activa la ubicación en tu navegador.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                mensaje = 'Información de ubicación no disponible.';
                                break;
                            case error.TIMEOUT:
                                mensaje = 'Tiempo de espera agotado.';
                                break;
                            default:
                                mensaje = 'Error desconocido al obtener la ubicación.';
                        }
                        estadoUbicacion.innerHTML = `<span class="text-error">${mensaje}</span>`;
                        latInput.value = '';
                        lngInput.value = '';
                    }
                );
            });
        </script>

        //COMPRESOR DE IMAGENES
        <script>
            document.getElementById('foto_perfil').addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (!file) return;

                const reader = new FileReader();

                reader.onload = function(event) {
                    const img = new Image();

                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        const maxWidth = 800;

                        let width = img.width;
                        let height = img.height;

                        if (width > maxWidth) {
                            height *= maxWidth / width;
                            width = maxWidth;
                        }

                        canvas.width = width;
                        canvas.height = height;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        canvas.toBlob(function(blob) {
                            const newFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });

                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(newFile);

                            document.getElementById('foto_perfil').files = dataTransfer.files;
                        }, 'image/jpeg', 0.7); // calidad 70%
                    };

                    img.src = event.target.result;
                };

                reader.readAsDataURL(file);
            });
        </script>
    </body>
</html>