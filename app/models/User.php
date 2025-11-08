<?php
class User extends Model
{
    public function getByEmail($email)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_viajeros WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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
}
