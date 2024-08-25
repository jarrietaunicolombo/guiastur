<?php

namespace Api\Helpers;

class CookiesSetup
{
    private $cookieName = "auth_token";
    private $secure = true;
    private $httpOnly = true;
    private $path = "/";

    public function setAuthTokenCookie($token, $expirationTime = 3600)
    {
        setcookie($this->cookieName, $token, time() + $expirationTime, $this->path, "", $this->secure, $this->httpOnly);
    }

    public function getAuthTokenFromCookie()
    {
        return $_COOKIE[$this->cookieName] ?? '';
    }

    public function clearAuthTokenCookie()
    {
        setcookie($this->cookieName, "", time() - 3600, $this->path, "", $this->secure, $this->httpOnly);
    }
}
