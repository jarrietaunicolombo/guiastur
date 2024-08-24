<?php

function setupCookies($userId, $userRole = null, $userCreationId = null)
{
    if (!$userId) {
        throw new \Exception("userId no está definido");
    }

    setcookie("user_id", $userId, [
        'expires' => time() + 86400,
        'path' => '/',
        'domain' => 'guiastur-mobile.test',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);

    if ($userRole) {
        setcookie("user_role", $userRole, [
            'expires' => time() + 86400,
            'path' => '/',
            'domain' => 'guiastur-mobile.test',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }

    if ($userCreationId) {
        setcookie("user_creation_id", $userCreationId, [
            'expires' => time() + 86400,
            'path' => '/',
            'domain' => 'guiastur-mobile.test',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
}
