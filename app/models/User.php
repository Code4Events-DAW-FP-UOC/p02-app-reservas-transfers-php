<?php
class User extends Model
{
    public function registro($nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password, $rol)
    {
        $db = $this->db();
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare(
            "INSERT INTO `transfer_viajeros` 
            (`nombre`, `apellido1`, `apellido2`, `direccion`, `codigoPostal`, `ciudad`, `pais`, `email`, `password`, `rol`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $nombre,
            $apellido1,
            $apellido2,
            $direccion,
            $codigoPostal,
            $ciudad,
            $pais,
            $email,
            $hash,
            $rol
        ]);
    }

    public function getByEmail($email)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_viajeros WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_viajeros WHERE id_viajero = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $password = null)
    {
        $db = $this->db();

        // Si se pasa una nueva contraseña, la actualiza. Si no, la deja como está.
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE transfer_viajeros 
                SET nombre = ?, apellido1 = ?, apellido2 = ?, direccion = ?, codigoPostal = ?, ciudad = ?, pais = ?, password = ?
                WHERE id_viajero = ?";
            $params = [$nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $hash, $id];
        } else {
            $sql = "UPDATE transfer_viajeros 
                SET nombre = ?, apellido1 = ?, apellido2 = ?, direccion = ?, codigoPostal = ?, ciudad = ?, pais = ?
                WHERE id_viajero = ?";
            $params = [$nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $id];
        }
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }
}
