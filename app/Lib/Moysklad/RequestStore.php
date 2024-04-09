<?php


namespace App\Lib\Moysklad;

use App\Models\Setting;
use Ixudra\Curl\Facades\Curl;

class RequestStore
{
    private $token;
    protected $response;

    public function __construct()
    {
        $this->token = (new Setting())->token();
    }

    public function send(string $href)
    {
        $this->response = Curl::to($href)
            ->withAuthorization($this->token)
            ->withHeader('Accept-Encoding: gzip')
            ->withOption('ENCODING', 'gzip')
            ->asJson()
            ->get();

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
