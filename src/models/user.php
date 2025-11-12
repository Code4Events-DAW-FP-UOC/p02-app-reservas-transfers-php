<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Busca al usuario mediante su email.
     */
    public function findByEmail($email)
    {
        // Usa la tabla 'transfer_viajeros'
        $stmt = $this->pdo->prepare('SELECT * FROM transfer_viajeros WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function register($data)
    {
   
        if ($this->findByEmail($data['email'])) {
            return false; // Comprueba que el usuario existe
        }

    
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

       
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
            return true; // Registro correcto
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false; // Error en insertar
        }
    }

    /**
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