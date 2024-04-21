<?php


namespace App\Lib\Moysklad;

use Ixudra\Curl\Facades\Curl;

class MojSkladJsonApi
{
    protected $context = [];
    protected $rows = [];
    protected $meta = [];
    protected $error = [];

    public function send(string $href): void
    {
        $token = (new StoreToken())->getToken();

        $response = Curl::to($href)
            ->withAuthorization($token)
            ->withHeader('Accept-Encoding: gzip')
            ->withOption('ENCODING', 'gzip')
            ->get();

        $response = json_decode($response, true);

        if(array_key_exists('errors', $response))
            $this->error = $response['errors'];
        else{
            $this->rows = $response['rows'];
            $this->meta = $response['meta'];
            $this->context = $response['context'];
        }
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function getErrors(): array
    {
        return $this->error;
    }
}
