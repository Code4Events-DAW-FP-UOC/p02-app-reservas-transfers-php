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
}
