<?php
require_once 'Modelos/UsuarioModelo.php';

class ControladorRegistro {
    private $usuarioModelo;
    public function __construct() {
        $this->usuarioModelo = new UsuarioModelo();
    }

    public function index() {
        $this->renderizar('Login/registro');
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errores = [];

            // Validaciones básicas de campos de texto
            if (empty($_POST['nombre'])) $errores[] = 'El nombre es obligatorio';
            if (empty($_POST['apellido_paterno'])) $errores[] = 'El apellido paterno es obligatorio';
            if (empty($_POST['correo'])) $errores[] = 'El correo es obligatorio';
            if (empty($_POST['password'])) $errores[] = 'La contraseña es obligatoria';
            if (strlen($_POST['password']) < 6) $errores[] = 'La contraseña debe tener al menos 6 caracteres';
            if (empty($_POST['fecha_nacimiento'])) $errores[] = 'La fecha de nacimiento es obligatoria';

            // Validación de foto de perfil (si se subió)
            $foto_binaria = null;
            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE) {
                $archivo = $_FILES['foto_perfil'];
                if ($archivo['error'] !== UPLOAD_ERR_OK) {
                    $errores[] = 'Error al subir la foto: ' . $this->getUploadErrorMessage($archivo['error']);
                } else {
                    $tipo = mime_content_type($archivo['tmp_name']);
                    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($tipo, $tipos_permitidos)) {
                        $errores[] = 'La foto debe ser JPG, PNG o GIF';
                    }
                    $tamano_maximo = 16 * 1024 * 1024; // 16 MB
                    if ($archivo['size'] > $tamano_maximo) {
                        $errores[] = 'La foto no debe exceder los 16 MB';
                    }
                    if (empty($errores)) {
                        $foto_binaria = file_get_contents($archivo['tmp_name']);
                    }
                }
            }

            // Obtener ubicación (campos ocultos)
            $latitud = isset($_POST['latitud']) && $_POST['latitud'] !== '' ? (float)$_POST['latitud'] : null;
            $longitud = isset($_POST['longitud']) && $_POST['longitud'] !== '' ? (float)$_POST['longitud'] : null;

            // Si no hay errores hasta ahora, verificar duplicado y crear usuario
            if (empty($errores)) {
                if ($this->usuarioModelo->existeCorreo($_POST['correo'])) {
                    $errores[] = 'El correo ya está registrado';
                } else {
                    $datos = [
                        'nombre' => $_POST['nombre'],
                        'apellido_paterno' => $_POST['apellido_paterno'],
                        'apellido_materno' => $_POST['apellido_materno'] ?? null,
                        'apodo' => $_POST['apodo'] ?? null,
                        'telefono' => $_POST['telefono'] ?? null,
                        'correo' => $_POST['correo'],
                        'pass' => $_POST['password'],
                        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                        'genero' => $_POST['genero'] ?? null,
                        'biografia' => $_POST['biografia'] ?? null,
                        'foto_perfil' => $foto_binaria,
                        'latitud' => $latitud,
                        'longitud' => $longitud
                    ];

                    if ($this->usuarioModelo->crear($datos)) {
                        header('Location: index.php?c=login&a=index&registro=exitoso');
                        exit;
                    } else {
                        $errores[] = 'Error al registrar usuario';
                    }
                }
            }

            // Si hay errores, volvemos a mostrar el formulario con los mensajes
            $this->renderizar('Login/registro', ['errores' => $errores]);
        } else {
            $this->index();
        }
    }

    private function renderizar($vista, $datos = []) {
        extract($datos);
        //require_once 'Vistas/Layout/header.php';
        require_once "Vistas/{$vista}.php";
        require_once 'Vistas/Layout/footer.php';
    }

    private function getUploadErrorMessage($code) {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                return 'El archivo excede el tamaño máximo permitido por el servidor.';
            case UPLOAD_ERR_FORM_SIZE:
                return 'El archivo excede el tamaño máximo permitido por el formulario.';
            case UPLOAD_ERR_PARTIAL:
                return 'El archivo solo se subió parcialmente.';
            case UPLOAD_ERR_NO_FILE:
                return 'No se seleccionó ningún archivo.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Falta la carpeta temporal.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'No se pudo escribir el archivo en el disco.';
            case UPLOAD_ERR_EXTENSION:
                return 'Una extensión de PHP detuvo la subida.';
            default:
                return 'Error desconocido.';
        }
    }
}
?>