<?php

namespace Api\Helpers;

class CookiesSetup
{
    private $authCookieName = "auth_token";
    private $refreshCookieName = "refresh_token";
    private $secure = false;
    private $domain = 'http://localhost:8100';
    private $httpOnly = true;
    private $path = "/";
    private $sameSite = "Strict";

    public function setAuthTokenCookie($token, $expirationTime = 3600)
    {

        $cookieSet = setcookie(
            $this->authCookieName,
            $token,
            [
                'expires' => time() + $expirationTime,
                'path' => '/',
                'domain' => $this->domain,
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );

    }

    public function setRefreshTokenCookie($token, $expirationTime = 604800)
    {
        setcookie(
            $this->refreshCookieName,
            $token,
            [
                'expires' => time() + $expirationTime,
                'path' => '/',
                'domain' => $this->domain,
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );
    }

    public function getAuthTokenFromCookie()
    {
        $token = $_COOKIE[$this->authCookieName] ?? null;
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
                'domain' => $this->domain,
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );

    }

    public function clearRefreshTokenCookie()
    {
        setcookie(
            $this->refreshCookieName,
            "",
            [
                'expires' => time() - 3600,
                'path' => $this->path,
                'domain' => $this->domain,
                'secure' => $this->secure,
                'httponly' => $this->httpOnly,
                'samesite' => $this->sameSite,
            ]
        );

    }
}
