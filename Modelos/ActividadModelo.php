<?php
require_once 'Config\config.php';

class ActividadModelo {
    private $db;

    public function __construct() {
        $this->db = Database::getConexion();
    }

    // Método existente
    public function getActividadesPublicas() {
        $sql = "
            SELECT 
                a.idActividad,
                a.Nombre,
                a.Descripcion,
                a.FechaInicio,
                a.FechaFin,
                a.MinParticipantes,
                a.MaxParticipantes,
                u.Nombre AS OrganizadorNombre,
                u.ApellidoPaterno AS OrganizadorApellido,
                u.idUsuario AS idOrganizador,
                ubi.Latitud,
                ubi.Longitud,
                ubi.Direccion,
                ta.Nombre AS TipoActividad
            FROM Actividad a
            INNER JOIN UbicacionActividad ubi ON a.idUbicacionActividad = ubi.idUbicacionActividad
            INNER JOIN Usuario u ON a.idOrganizador = u.idUsuario
            INNER JOIN TipoActividad ta ON a.idTipoActividad = ta.idTipoActividad
            INNER JOIN EstadoActividad ea ON a.idEstadoActividad = ea.idEstadoActividad
            WHERE a.AccesoPublico = 1
              AND ea.Nombre != 'Cancelada'
              AND ubi.Latitud IS NOT NULL 
              AND ubi.Longitud IS NOT NULL
            ORDER BY a.FechaInicio ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearActividad($datos, $idOrganizador) {
        $this->db->beginTransaction();
        try {
            // Insertar ubicación
            $sqlUbicacion = "INSERT INTO UbicacionActividad (Latitud, Longitud, Direccion) VALUES (?, ?, ?)";
            $stmtUbicacion = $this->db->prepare($sqlUbicacion);
            $stmtUbicacion->execute([
                $datos['latitud'],
                $datos['longitud'],
                $datos['direccion']
            ]);
            $idUbicacion = $this->db->lastInsertId();

            // Insertar actividad
            $sqlActividad = "
                INSERT INTO Actividad (
                    idOrganizador, idUbicacionActividad, idTipoActividad, Nombre,
                    AccesoPublico, MinParticipantes, MaxParticipantes,
                    EdadMin, EdadMax, Descripcion, FechaInicio, FechaFin
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $stmtActividad = $this->db->prepare($sqlActividad);
            $stmtActividad->execute([
                $idOrganizador,
                $idUbicacion,
                $datos['tipo_actividad'],
                $datos['nombre'],
                $datos['acceso_publico'],
                $datos['min_participantes'],
                $datos['max_participantes'],
                $datos['edad_min'],
                $datos['edad_max'],
                $datos['descripcion'],
                $datos['fecha_inicio'],
                $datos['fecha_fin']
            ]);
            $idActividad = $this->db->lastInsertId();

            // Inscribir al organizador automáticamente
            $sqlParticipante = "INSERT INTO ParticipanteActividad (idActividad, idUsuario, Estado) VALUES (?, ?, 'Confirmado')";
            $stmtParticipante = $this->db->prepare($sqlParticipante);
            $stmtParticipante->execute([$idActividad, $idOrganizador]);

            $this->db->commit();
            return $idActividad;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error al crear actividad: " . $e->getMessage());
            return false;
        }
    }
}
?>