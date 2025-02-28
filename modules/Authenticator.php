<?php

class Authenticator
{
    public static function verifyToken($headers)
    {
        $authHeader = $headers['Authorization'] ?? null;

        // Example logic to check for a valid token
        if ($authHeader === 'Bearer super-secret-token') {
            return true;
        }

        return false;
    }
}
