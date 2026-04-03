<?php
require_once 'Database.php';

class UsuarioModelo {
    private $pdo;
    public function __construct() {
        $this->pdo = Database::getConexion();
    }
    public function buscarPorCorreo($correo) {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuario WHERE Correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function crear($datos) {
        $sql = "INSERT INTO Usuario (Nombre, ApellidoPaterno, ApellidoMaterno, Apodo, Telefono, Correo, Pass, FechaNacimiento, Genero, Biografia, FotoPerfil, UbicacionLatitud, UbicacionLongitud)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $hashPass = password_hash($datos['pass'], PASSWORD_DEFAULT);
        // foto_perfil puede ser null si no se subió
        $fotoPerfil = isset($datos['foto_perfil']) ? $datos['foto_perfil'] : null;
        $latitud = isset($datos['latitud']) && $datos['latitud'] !== '' ? $datos['latitud'] : null;
        $longitud = isset($datos['longitud']) && $datos['longitud'] !== '' ? $datos['longitud'] : null;
        return $stmt->execute([
            $datos['nombre'],
            $datos['apellido_paterno'],
            $datos['apellido_materno'],
            $datos['apodo'],
            $datos['telefono'],
            $datos['correo'],
            $hashPass,
            $datos['fecha_nacimiento'],
            $datos['genero'],
            $datos['biografia'],
            $fotoPerfil,
            $latitud,
            $longitud
        ]);
    }
    public function existeCorreo($correo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Usuario WHERE Correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetchColumn() > 0;
    }
    public function obtenerUbicacion($idUsuario) {
        $stmt = $this->pdo->prepare("SELECT UbicacionLatitud, UbicacionLongitud FROM Usuario WHERE idUsuario = ?");
        $stmt->execute([$idUsuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Agregar dentro de la clase UsuarioModelo
    public function actualizarUbicacion($idUsuario, $latitud, $longitud) {
        $stmt = $this->pdo->prepare("UPDATE Usuario SET UbicacionLatitud = ?, UbicacionLongitud = ? WHERE idUsuario = ?");
        return $stmt->execute([$latitud, $longitud, $idUsuario]);
    }


}
?>