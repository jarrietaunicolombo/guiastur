<?php

namespace Api\Helpers;

class CookiesSetup
{
    private $authCookieName = "auth_token";
    private $refreshCookieName = "refresh_token";
    private $secure = true;
    private $httpOnly = true;
    private $path = "/";
    private $sameSite = "None";

    public function setAuthTokenCookie($token, $expirationTime = 60)
    {
        error_log("Seteando cookie auth_token con token: " . $token);

        $cookieSet = setcookie(
            $this->authCookieName,
            $token,
            [
                'expires' => time() + $expirationTime,
                'path' => '/',
                'domain' => 'guiastur-mobile-app.test',
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );

        error_log("Cookie auth_token seteada correctamente: " . ($cookieSet ? 'Sí' : 'No'));

        /*if ($cookieSet) {
            error_log("Cookie auth_token configurada correctamente.");
        } else {
            error_log("Error al configurar la cookie auth_token.");
        }

        if (isset($_COOKIE[$this->authCookieName])) {
            error_log("Cookie auth_token está presente en \$_COOKIE justo después de la configuración.");
        } else {
            error_log("Cookie auth_token no está presente en \$_COOKIE después de la configuración.");
        }*/
    }

    public function setRefreshTokenCookie($token, $expirationTime = 604800)
    {
        error_log("Seteando cookie refresh_token con token: " . $token);
        setcookie(
            $this->refreshCookieName,
            $token,
            [
                'expires' => time() + $expirationTime,
                'path' => '/',
                'domain' => 'guiastur-mobile-app.test',
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );
    }

    public function getAuthTokenFromCookie()
    {
        error_log("Obteniendo cookie auth_token: " . print_r($_COOKIE, true));
        $token = $_COOKIE[$this->authCookieName] ?? null;
        error_log("Token auth_token obtenido: " . ($token ?? 'Nulo'));
        return $token;
    }

    public function getRefreshTokenFromCookie()
    {
        return $_COOKIE[$this->refreshCookieName] ?? null;
    }

    public function clearAuthTokenCookie()
    {
        setcookie(
            $this->authCookieName,
            "",
            [
                'expires' => time() - 3600,
                'path' => $this->path,
                'domain' => 'guiastur-mobile-app.test',
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );

        setcookie(
            $this->authCookieName,
            "",
            [
                'expires' => time() - 7200,
                'path' => $this->path,
                'domain' => 'guiastur-mobile-app.test',
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );

        error_log("Cookie auth_token eliminada.");
    }

    public function clearRefreshTokenCookie()
    {
        setcookie(
            $this->refreshCookieName,
            "",
            [
                'expires' => time() - 3600,
                'path' => $this->path,
                'domain' => 'guiastur-mobile-app.test',
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );

        error_log("Cookie refresh_token eliminada: " . print_r($_COOKIE, true));
    }
}
