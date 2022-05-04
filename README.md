## Requisitos

- Projeto em [laravel](https://laravel.com);

## Instalação

Antes de adicionar a dependência ao projeto, é necessário informar ao composer que esta dependência está no GitHub e não no Packagist.org.
No arquivo `composer.json`, adicione o seguinte JSON:
```json
    "repositories": {
        "sgbrsist/custom-request": {
            "type": "git",
            "url": "https://github.com/sgbrsist/custom-request.git",
            "reference": "main"
        }
    },
```

Adicione a dependência ao projeto com o seguinte comando:
```
composer require sgbrsist/custom-request
```

Ao executar o require, devido ao fato do projeto ser privado, será necessário gerar um token de acesso para que o composer consiga acessar o repositório
1. Acesse https://github.com/settings/tokens;
2. Crie um novo token com as permissões `write:packages` e `read:packages`;
3. Informe o token quando o composer exigir.

## Uso

```php
use Sgbrsist\CustomRequest\CustomRequestInterface;

// Instancie a classe utilizando o container do laravel:
$req = app(CustomRequestInterface::class);

// É possível encadear vários métodos set:
$req->setRoute('https://myapi.com/')
        ->setContentType('application/json');

// Adicione formdata através de arrays associativos:
$req->addFormData([
    'someField' => 'someValue',
    'anotherField' => 'anotherValue'
]);

// Adicione JSON direto de um json_encode ou passe um array associativo
$req->addJson(json_encode($myObj));
$req->addJson([
    'someProperty' => 'someValue',
    'anotherProperty' => 'anotherValue'
]);

// Adicione headers personalizados
$req->setHeaders([
    'Token' => "Bearer $myToken"
]);

// Envie requisições GET, POST, PUT, PATCH, DELETE
if ($req->get()) {
    return Response::json(json_decode($req->response->getAsJson()));

return Response::json([
    'message' => 'Requisição falhou',
    'code' => $req->response->getCode()
    ], 500);
```

## Contribuições

Paga um Chopp pro [Castor](https://github.com/WesleyLamb), é nóis.