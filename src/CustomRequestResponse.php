<?php

namespace Sgbrsist\CustomRequest;

use Sgbrsist\CustomRequest\CustomRequestResponseInterface;

class CustomRequestResponse implements CustomRequestResponseInterface 
{
    private $code,
            $asJson,
            $asString;

    public function handleResponse(string $body, array $info)
    {
        $this->code = $info['http_code'];
        $this->asJson = json_decode($body);
        $this->asString = $body;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getAsJson()
    {
        return $this->asJson;
    }

    public function getAsString()
    {
        return $this->asString;
    }
}