<?php


namespace App\Lib\Moysklad;

use Ixudra\Curl\Facades\Curl;

abstract class StoreRequest
{
    protected $href;
    protected $response;

    abstract public function getApi(): array;

    public function setHref(string $href): void
    {
        $this->href = $href;
    }

    protected function send()
    {
        $token = (new StoreToken())->getToken();

        $response = Curl::to($this->href)
            ->withAuthorization($token)
            ->withHeader('Accept-Encoding: gzip')
            ->withOption('ENCODING', 'gzip')
            ->get();

        $this->response = json_decode($response, true);

        return $this;
    }

    protected function getResponse()
    {
        return $this->response;
    }
}
