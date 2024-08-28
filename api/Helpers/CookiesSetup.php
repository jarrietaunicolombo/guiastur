<?php

namespace Api\Helpers;

class CookiesSetup
{
    private $authCookieName = "auth_token";
    private $refreshCookieName = "refresh_token";
    private $secure = true;
    private $httpOnly = true;
    private $path = "";
    private $sameSite = "None";

    public function setAuthTokenCookie($token, $expirationTime = 3600)
    {
        error_log("Valor del token antes de configurar la cookie: " . $token);
        $cookieSet = setcookie(
            $this->authCookieName,
            $token,
            [
                'expires' => time() + $expirationTime,
                'path' => $this->path,
                'domain' => 'guiastur-mobile-app.test',
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );

        if ($cookieSet) {
            error_log("Cookie auth_token configurada correctamente.");
        } else {
            error_log("Error al configurar la cookie auth_token.");
        }
        error_log("Cookie auth_token configurada: " . print_r($_COOKIE, true));
    }

    public function setRefreshTokenCookie($token, $expirationTime = 604800)
    {
        setcookie(
            $this->refreshCookieName,
            $token,
            [
                'expires' => time() + $expirationTime,
                'path' => $this->path,
                'domain' => 'guiastur-mobile-app.test',
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );
    }


    public function getAuthTokenFromCookie()
    {
        return $_COOKIE[$this->authCookieName] ?? null;
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
