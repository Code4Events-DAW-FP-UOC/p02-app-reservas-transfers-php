<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Busca un usuari pel seu email.
     */
    public function findByEmail($email)
    {
        // Corregido: Usar la tabla 'transfer_viajeros'
        $stmt = $this->pdo->prepare('SELECT * FROM transfer_viajeros WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    /**
     * Registra un usuari nou a la BBDD.
     * Corregido: Usar todos los campos de la BBDD
     */
    public function register($data)
    {
        // 1. Comprovem si l'email ja existeix
        if ($this->findByEmail($data['email'])) {
            return false; // L'usuari ja existeix
        }

        // 2. Encriptem la contrasenya
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // 3. Inserim l'usuari (Corregido: consulta SQL con todas las columnas)
        try {
            $sql = "INSERT INTO transfer_viajeros 
                        (nombre, apellido1, apellido2, email, password, direccion, codigoPostal, ciudad, pais) 
                    VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->execute([
                $data['nombre'],
                $data['apellido1'],
                $data['apellido2'],
                $data['email'],
                $hashedPassword,
                $data['direccion'],
                $data['codigoPostal'],
                $data['ciudad'],
                $data['pais']
            ]);
            return true; // Registre correcte
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false; // Error en inserir
        }
    }

    /**
     * Comprova el login d'un usuari.
     * (Esta función ya estaba bien)
     */
    public function login($email, $password)
    {
        $user = $this->findByEmail($email);

        // Usamos la columna 'password' que sí existe
        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }
}
?>