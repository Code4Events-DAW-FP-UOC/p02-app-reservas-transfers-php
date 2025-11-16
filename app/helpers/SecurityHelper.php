<?php
// app/helpers/SecurityHelper.php

/**
 * Helper estático para funciones de seguridad: hashing y verificación de contraseñas.
 */
class SecurityHelper
{
    /**
     * Genera un hash seguro para la contraseña.
     * @param string $plainPassword Contraseña en texto plano.
     * @return string Hash seguro.
     */
    public static function hashPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }

    /**
     * Verifica si la contraseña en texto plano coincide con el hash almacenado.
     * @param string $plainPassword Contraseña introducida por el usuario.
     * @param string $hash Hash almacenado en la base de datos.
     * @return bool True si la contraseña es válida.
     */
    public static function verifyPassword($plainPassword, $hash)
    {
        return password_verify($plainPassword, $hash);
    }
}
