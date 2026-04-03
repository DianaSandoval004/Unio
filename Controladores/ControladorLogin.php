<?php
require_once 'Modelos/UsuarioModelo.php';

class ControladorLogin {
    private $usuarioModelo;
    public function __construct() {
        $this->usuarioModelo = new UsuarioModelo();
    }
    public function index() {
        $this->renderizar('Login/login');
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $correo = $_POST['correo'] ?? '';
            $pass = $_POST['password'] ?? '';
            if (empty($correo) || empty($pass)) {
                $this->renderizar('Login/login', ['error' => 'Complete todos los campos']);
                return;
            }
            $usuario = $this->usuarioModelo->buscarPorCorreo($correo);
            if ($usuario && password_verify($pass, $usuario['Pass'])) {
                $_SESSION['usuario_id'] = $usuario['idUsuario'];
                $_SESSION['usuario_nombre'] = $usuario['Nombre'] . ' ' . $usuario['ApellidoPaterno'];
                $_SESSION['usuario_correo'] = $usuario['Correo'];
                header('Location: index.php?c=dashboard&a=index');
                exit;
            } else {
                $this->renderizar('Login/login', ['error' => 'Credenciales incorrectas']);
            }
        } else {
            $this->index();
        }
    }
    public function logout() {
        session_destroy();
        header('Location: index.php?c=login');
        exit;
    }
    private function renderizar($vista, $datos = []) {
        extract($datos);
        require_once "Vistas/{$vista}.php";
        require_once 'Vistas/Layout/footer.php';
    }
}
?>