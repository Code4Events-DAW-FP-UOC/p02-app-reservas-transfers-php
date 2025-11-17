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
    // 1. Obtenir usuari per ID 
    public function findById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM transfer_viajeros WHERE id_viajero = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Actualitzar dades 
    public function update($id, $nombre, $email, $password = null)
    {
        try {
            if ($password) {
                // Si hi ha contrasenya nova, l'encriptem i actualitzem tot
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $sql = "UPDATE transfer_viajeros SET nombre = ?, email = ?, password = ? WHERE id_viajero = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$nombre, $email, $hashedPassword, $id]);
            } else {
                // Si NO hi ha contrasenya, només actualitzem nom i email
                $sql = "UPDATE transfer_viajeros SET nombre = ?, email = ? WHERE id_viajero = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$nombre, $email, $id]);
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error update user: " . $e->getMessage());
            return false;
        }
    }
}
?>