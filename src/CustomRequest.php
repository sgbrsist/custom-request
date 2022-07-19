<?php

namespace Sgbrsist\CustomRequest;

class CustomRequest implements CustomRequestInterface
{
    private $route,
    $formData = [],
    $json,
    $headers = [],
    $sslCertPath,
    $sslKeyPath;
    public $response;

    public function __construct()
    {
        $this->headers['Content-Type'] = 'application/json';
    }

    public function setRoute(string $route)
    {
        $this->route = $route;
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setContentType(string $contentType)
    {
        $this->headers['Content-Type'] = $contentType;
        return $this;
    }

    public function setHeaders(array $headers)
    {
        foreach ($headers as $key => $value) {
            $this->headers[$key] = $value;
        }
        return $this;
    }

    public function setCerts($sslCertPath, $sslKeyPath)
    {
        $this->sslCertPath = $sslCertPath;
        $this->sslKeyPath = $sslKeyPath;
        return $this;
    }

    public function addFormData(array $pairs)
    {
        $this->setContentType('application/x-www-form-urlencoded');
        foreach ($pairs as $key => $value)
            $this->formData[$key] = $value;
        return $this;
    }

    public function addJson()
    {
        $this->setContentType('application/json');
        
        if (gettype(func_get_arg(0)) == 'array')
            $this->json = json_encode(func_get_arg(0));
        else
            $this->json = func_get_arg(0);

        return $this;
    }

    public function getBody() {
        if ($this->json)
            return json_decode($this->json);
        if ($this->formData)
            return $this->formData;
        return null;
    }

    public function get() {
        $resp = false;
        $curl = $this->prepareCurl();

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        
        $resp = $this->handleResponse(curl_exec($curl), curl_getinfo($curl));
        
        curl_close($curl);
        return $resp;
    }

    public function post() {
        $resp = false;
        $curl = $this->prepareCurl();

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        
        $resp = $this->handleResponse(curl_exec($curl), curl_getinfo($curl));
        
        curl_close($curl);
        return $resp;
    }

    public function put() {
        $resp = false;
        $curl = $this->prepareCurl();

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        
        $resp = $this->handleResponse(curl_exec($curl), curl_getinfo($curl));
        
        curl_close($curl);
        return $resp;
    }

    public function patch() {
        $resp = false;
        $curl = $this->prepareCurl();

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        
        $resp = $this->handleResponse(curl_exec($curl), curl_getinfo($curl));
        
        curl_close($curl);
        return $resp;
    }

    public function delete() {
        $resp = false;
        $curl = $this->prepareCurl();

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        $resp = $this->handleResponse(curl_exec($curl), curl_getinfo($curl));
        
        curl_close($curl);
        return $resp;
    }

    private function prepareCurl() {
        $preparedHeaders = [];
        foreach ($this->headers as $key => $value)  
            $preparedHeaders[] = $key . ': ' . $value;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->route);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if (count($preparedHeaders) > 0)
            curl_setopt($curl, CURLOPT_HTTPHEADER, $preparedHeaders);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        if ($this->sslCertPath && $this->sslKeyPath) {
            curl_setopt($curl, CURLOPT_SSLCERT, $this->sslCertPath);
            curl_setopt($curl, CURLOPT_SSLKEY, $this->sslKeyPath);
        }
        if ($this->json)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->json);
        else if (count($this->formData) > 0)
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->formData));

        return $curl;
    }

    private function handleResponse(string $response, array $info) {
        $this->response = app(CustomRequestResponseInterface::class);
        
        $this->response->handleResponse($response, $info);

        return in_array($this->response->getCode(), [200, 201, 202, 204]);
    }
}