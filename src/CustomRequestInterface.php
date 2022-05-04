<?php

namespace Sgbrsist\CustomRequest;

interface CustomRequestInterface 
{
    public function setRoute(string $route);
    public function setContentType(string $contentType);
    public function setHeaders(array $headers);
    public function addFormData(array $pair);
    public function addJson();

    public function get();
    public function post();
    public function put();
    public function patch();
    public function delete();
}