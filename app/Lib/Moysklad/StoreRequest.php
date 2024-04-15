<?php


namespace App\Lib\Moysklad;

use Ixudra\Curl\Facades\Curl;

class StoreRequest
{
    private $token;
    protected $response;

    public function __construct()
    {
        $this->token = (new StoreToken())->getToken();
    }

    public function send(string $href)
    {
        $response = Curl::to($href)
            ->withAuthorization($this->token)
            ->withHeader('Accept-Encoding: gzip')
            ->withOption('ENCODING', 'gzip')
            ->get();

        $this->response = json_decode($response, true);

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
