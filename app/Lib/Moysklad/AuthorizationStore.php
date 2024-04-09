<?php


namespace App\Lib\Moysklad;

use Ixudra\Curl\Facades\Curl;

class AuthorizationStore
{
    protected $login;
    protected $password;
    protected $href = 'https://api.moysklad.ru/api/remap/1.2/security/token';

    public function token()
    {
        $response = Curl::to($this->href)
            ->withAuthorization('Basic ' . base64_encode(implode(':', [$this->getLogin(), $this->getPassword()])))
            ->withHeader('Accept-Encoding: gzip')
            ->withOption('ENCODING', 'gzip')
            ->asJson()
            ->post();

        return $response;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
