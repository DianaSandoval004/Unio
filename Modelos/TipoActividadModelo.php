<?php
require_once 'Modelos/Database.php';

class TipoActividadModelo {
    private $db;

    public function __construct() {
        $this->db = Database::getConexion();
    }

    public function listarTipos() {
        $stmt = $this->db->prepare("SELECT idTipoActividad, Nombre FROM TipoActividad ORDER BY Nombre");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>