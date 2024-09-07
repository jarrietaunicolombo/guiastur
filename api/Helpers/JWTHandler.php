<?php

namespace Api\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Api\Models\UserToken;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/vendor/autoload.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Libs/Orm/Config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/UserToken.php";

class JWTHandler
{
    private static $secret_key = '97f48c9680894bb995f7eed170fe8f311e30d076a5eedefc6f8321c1cf976035'; // Asegúrate de que sea la misma que usaste al crear el token
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function createToken($data)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'aud' => self::aud(),
            'data' => $data
        ];

        $token = JWT::encode($payload, self::$secret_key, self::$encrypt[0]);
        error_log("Token JWT creado: " . $token);

        $userToken = new UserToken([
            'usuario_id' => $data['userId'],
            'token' => $token,
            'expira_el' => date('Y-m-d H:i:s', $expirationTime)
        ]);
        $userToken->save();

        return $token;
    }

    public static function validateToken($token)
    {
        error_log("Validando token JWT: " . $token);

        if (empty($token)) {
            throw new \Exception("Token no proporcionado.");
        }

        try {
            if (!\ActiveRecord\Config::instance()->get_default_connection()) {
                throw new \Exception("Empty connection string");
            }

            $decoded = JWT::decode($token, new Key(self::$secret_key, self::$encrypt[0]));
            error_log("Token decodificado: " . print_r($decoded, true));

            if ($decoded->aud !== self::aud()) {
                throw new \Exception("Audiencia inválida.");
            }

            error_log("Audiencia validada correctamente.");

            $userToken = UserToken::find('first', ['conditions' => ['token = ? AND expira_el > NOW()', $token]]);
            if (!$userToken) {
                throw new \Exception("Token no válido o expirado.");
            }

            error_log("Token validado en la base de datos.");
        } catch (\Exception $e) {
            error_log("Error en la validación del token: " . $e->getMessage());
            return false;
        }

        return true;
    }

    public static function decodeJWT($token)
    {
        try {
            return JWT::decode($token, new Key(self::$secret_key, self::$encrypt[0]));
        } catch (\Exception $e) {
            throw new \Exception("Error al decodificar el token: " . $e->getMessage());
        }
    }

    private static function aud()
    {
        if (!empty(self::$aud)) {
            return self::$aud;
        }

        self::$aud = sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
        return self::$aud;
    }
}
