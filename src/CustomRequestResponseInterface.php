<?php

namespace Sgbrsist\CustomRequest;

interface CustomRequestResponseInterface 
{
    public function handleResponse(string $body, array $info);
    public function getCode();
    public function getAsJson();
    public function getAsString();
}