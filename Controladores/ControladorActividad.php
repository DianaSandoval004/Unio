<?php
class ControladorActividad {
    public function nueva() {
        // Verificar sesión
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?c=login');
            exit;
        }

        // Obtener tipos de actividad para el formulario
        require_once 'Modelos/TipoActividadModelo.php';
        $tipoModelo = new TipoActividadModelo();
        $tipos = $tipoModelo->listarTipos();

        // Renderizar vista
        $this->renderizar('Actividades/nuevaActividad', ['tipos' => $tipos]);
    }

    public function guardar() {
        // Verificar sesión
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?c=login');
            exit;
        }

        // Validar datos del formulario
        $errores = [];
        
        $nombre = trim($_POST['nombre'] ?? '');
        if (empty($nombre)) $errores[] = 'El nombre de la actividad es obligatorio.';
        
        $tipo = $_POST['tipo_actividad'] ?? '';
        if (empty($tipo)) $errores[] = 'Debe seleccionar un tipo de actividad.';
        
        $latitud = $_POST['latitud'] ?? '';
        $longitud = $_POST['longitud'] ?? '';
        if (empty($latitud) || empty($longitud)) $errores[] = 'Debe seleccionar una ubicación en el mapa.';
        
        $fechaInicio = $_POST['fecha_inicio'] ?? '';
        $fechaFin = $_POST['fecha_fin'] ?? '';
        if (empty($fechaInicio)) $errores[] = 'La fecha de inicio es obligatoria.';
        if (empty($fechaFin)) $errores[] = 'La fecha de fin es obligatoria.';
        
        // Validar fechas
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $dtInicio = new DateTime($fechaInicio);
            $dtFin = new DateTime($fechaFin);
            if ($dtFin <= $dtInicio) {
                $errores[] = 'La fecha de fin debe ser posterior a la fecha de inicio.';
            }
        }

        if (!empty($errores)) {
            // Si hay errores, volver a mostrar el formulario con los errores
            require_once 'Modelos/TipoActividadModelo.php';
            $tipoModelo = new TipoActividadModelo();
            $tipos = $tipoModelo->listarTipos();
            $this->renderizar('Actividades/nuevaActividad', [
                'tipos' => $tipos,
                'errores' => $errores,
                'old' => $_POST
            ]);
            return;
        }

        // Preparar datos para el modelo
        $datos = [
            'nombre' => $nombre,
            'tipo_actividad' => $tipo,
            'latitud' => $latitud,
            'longitud' => $longitud,
            'direccion' => trim($_POST['direccion'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'min_participantes' => $_POST['min_participantes'] ?? '',
            'max_participantes' => $_POST['max_participantes'] ?? '',
            'edad_min' => $_POST['edad_min'] ?? '',
            'edad_max' => $_POST['edad_max'] ?? '',
            'acceso_publico' => isset($_POST['acceso_publico']) ? 1 : 0
        ];

        require_once 'Modelos/ActividadModelo.php';
        $actividadModelo = new ActividadModelo();
        $idActividad = $actividadModelo->crearActividad($datos, $_SESSION['usuario_id']);

        if ($idActividad) {
            // Redirigir al dashboard con mensaje de éxito
            $_SESSION['mensaje'] = 'Actividad creada exitosamente.';
            header('Location: index.php?c=dashboard');
            exit;
        } else {
            // Error al guardar
            $errores[] = 'Error al guardar la actividad. Intente nuevamente.';
            require_once 'Modelos/TipoActividadModelo.php';
            $tipoModelo = new TipoActividadModelo();
            $tipos = $tipoModelo->listarTipos();
            $this->renderizar('Actividades/nuevaActividad', [
                'tipos' => $tipos,
                'errores' => $errores,
                'old' => $_POST
            ]);
        }
    }

    private function renderizar($vista, $datos = []) {
        extract($datos);
        require_once 'Vistas/Layout/header.php';
        require_once "Vistas/{$vista}.php";
        require_once 'Vistas/Layout/footer.php';
    }
}
?>