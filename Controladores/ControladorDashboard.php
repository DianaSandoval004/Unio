<?php
class ControladorDashboard {
    public function index() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?c=login');
            exit;
        }

        // Obtener actividades públicas
        require_once 'Modelos/ActividadModelo.php';
        $actividadModelo = new ActividadModelo();
        $actividades = $actividadModelo->getActividadesPublicas();

        // Obtener ubicación del usuario actual
        require_once 'Modelos/UsuarioModelo.php';
        $usuarioModelo = new UsuarioModelo();
        $ubicacionUsuario = $usuarioModelo->obtenerUbicacion($_SESSION['usuario_id']);

        // Preparar datos para la vista
        $datosVista = [
            'actividades' => $actividades,
            'ubicacionUsuario' => $ubicacionUsuario
        ];

        // Renderizar vista
        $this->renderizar('Dashboard/index', $datosVista);
    }

    private function renderizar($vista, $datos = []) {
        extract($datos);
        //require_once 'Vistas/Layout/header.php';
        require_once "Vistas/{$vista}.php";
        require_once 'Vistas/Layout/footer.php';
    }

    public function actualizarUbicacion() {
        // Verificar sesión
        if (!isset($_SESSION['usuario_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }

        // Obtener datos POST
        $input = json_decode(file_get_contents('php://input'), true);
        $latitud = $input['latitud'] ?? null;
        $longitud = $input['longitud'] ?? null;

        if ($latitud === null || $longitud === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos inválidos']);
            exit;
        }

        require_once 'Modelos/UsuarioModelo.php';
        $usuarioModelo = new UsuarioModelo();
        $resultado = $usuarioModelo->actualizarUbicacion($_SESSION['usuario_id'], $latitud, $longitud);

        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar']);
        }
    }
        
}
?>