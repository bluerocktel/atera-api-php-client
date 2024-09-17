# php-sdk

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/bluerocktel/atera-api-php-client.svg?style=flat-square)](https://packagist.org/packages/bluerocktel/atera-api-php-client)
[![Total Downloads](https://img.shields.io/packagist/dt/bluerocktel/atera-api-php-client.svg?style=flat-square)](https://packagist.org/packages/bluerocktel/atera-api-php-client)


This package is a light PHP Client / SDK for the [Atera](https://atera.com/) API.

- [Installation](#installation)
- [Authentication](#authentication)
- [Usage](#usage)
  - [Requests](#usage-requests)
  - [Resources](#usage-resources)
  - [Responses](#usage-responses)
  - [Entities](#usage-entities)
  - [Pagination](#usage-pagination)
  - [Extending the SDK](#usage-extends)


<a name="installation"></a>

## Installation

This library requires PHP `>=8.1`.

You can install the package via composer:

```
composer require bluerocktel/atera-api-php-client
```

<a name="authentication"></a>

## Authentication

The autentication with the Atera API is made using an Api token you can retreive from the Atera admin panel. Read more in the [Atera documentation](https://support.atera.com/hc/fr/articles/219083397-API).


```php
use BlueRockTEL\AteraClient\AteraConnector;

$api = new AteraConnector(
    apiToken: 'secret_token',
    apiUrl: 'https://app.atera.com/api', // optional
);
```

After instancianting the `AteraConnector` class, you can start querying the API.

```php
$response = $api->agent()->index();

var_dump(
  $response->failed(), // true is the request returned 4xx or 5xx code.
  $response->json(),   // json response as an array
);
```

<a name="usage"></a>

## Usage

To query the API, you can either call each API [Endpoints requests](https://github.com/bluerocktel/atera-api-php-client/tree/main/src/Endpoints) individually, or make use of provided [Resources classes](https://github.com/bluerocktel/atera-api-php-client/tree/main/src/Resources) which groups the requests into clusters.


<a name="usage-requests"></a>

### Using Requests

Using single requests is pretty straightforward. You can use the `call()` method of the `AteraConnector` class to send the desired request to the instance :

```php
use BlueRockTEL\AteraClient\AteraConnector;
use BlueRockTEL\AteraClient\Endpoints;

$api = new AteraConnector('secret_token');

$response = $api->call(
  new Endpoints\Contacts\GetContactRequest(id: $contactId)
);
```

<a name="usage-resources"></a>

### Using Resources

Using resources is a more convenient way to query the API. Each Resource class groups requests by specific API namespaces (Customer, Agent, Contact...).

```php
use BlueRockTEL\AteraClient\AteraConnector;

$api = new AteraConnector('secret_token');

$query = [
    'searchOptions.email' => 'test@example.com',
];

$response = $api->contact()->index(
    query: $query,
    perPage: 20,
    page: 1,
);
```

Resources classes usually provide (but are not limited to) the following methods :

```php
class NamespaceResource
{
    public function index(array $params = [], int $perPage = 20, int $page = 1): Response;
    public function show(int $id): Response;
    public function store(Entity $entity): Response;
    public function update(Entity $entity): Response;
    public function upsert(Entity $entity): Response;
    public function delete(int $id): Response;
}
```

> 👉 The `upsert()` method is a simple alias : it will call the `update()` method if the given entity has an id, or the `store()` method otherwise.

Each of those namespace resources can be accessed using the `AteraConnector` instance :

```php
$connector = new AteraConnector(...);

$connector->agent(): Resources\AgentResource
$connector->customer(): Resources\CustomerResource
$connector->contact(): Resources\ContactResource
...
```

If needed, it is also possible to create the desired resource instance manually.

```php
use BlueRockTEL\AteraClient\AteraConnector;
use BlueRockTEL\AteraClient\Resources\AgentResource;

$api = new AteraConnector();
$resource = new AgentResource($api);

$agent = $resource->show($agentId);
$resource->upsert($agent);
```

<a name="usage-responses"></a>

### Responses

Weither you are using Requests or Resources, the response is always an instance of `Saloon\Http\Response` class.
It provides some useful methods to check the response status and get the response data.

```php
// Check response status
$response->ok();
$response->failed();
$response->status();
$response->headers();

// Get response data
$response->json(); # as an array
$response->body(); # as an raw string
$response->dtoOrFail(); # as a Data Transfer Object
```

You can learn more about responses by reading the [Saloon documentation](https://docs.saloon.dev/the-basics/responses#useful-methods), which this SDK uses underneath.

<a name="usage-entities"></a>

### Entities (DTO)

When working with APIs, dealing with a raw or JSON response can be tedious and unpredictable.

To make it easier, this SDK provides a way to transform the response data into a Data Transfer Object (DTO) (later called Entities). This way, you are aware of the structure of the data you are working with, and you can access the data using object typed properties instead of untyped array keys.


```php
$response = $api->agent()->show(id: 92);

/** @var \BlueRockTEL\AteraClient\Entities\Agent */
$agent = $response->dtoOrFail();
```


Although you can use the `dto()` method to transform the response data into an entity, it is recommended to use the `dtoOrFail()` method instead. This method will throw an exception if the response status is not 2xx, instead of returning an empty DTO.

It is still possible to access the underlying response object using the `getResponse()` method of the DTO :

```php
$entity = $response->dtoOrFail();   // \BlueRockTEL\AteraClient\Contracts\Entity
$entity->getResponse();             // \Saloon\Http\Response
```

> Learn more about working with Data tranfert objects on the [Saloon documentation](https://docs.saloon.dev/digging-deeper/data-transfer-objects).

The create/update/upsert routes will often ask for a DTO as first parameter :

```php
use BlueRockTEL\AteraClient\Entities\Customer;

// create
$response = $api->customer()->store(
    customer: new Customer(
        CustomerName: 'Acme Enterprise',
        City: 'Paris',
    ),
);

$customer = $response->dtoOrFail();

// update
$customer->CustomerName = 'Acme Enterprise Inc.';
$api->customer()->update($customer);
```


<a name="usage-pagination"></a>

### Pagination

On some index/search routes, the Atera API will use a pagination.
If you need to iterate on all pages of the endpoint, you may find handy to use the connector's `paginate()` method :

```php
# Create a PagedPaginator instance
$paginator = $api->paginate(new GetCustomersRequest());

# Iterate on all pages entities, using lazy loading for performance
foreach ($paginator->items() as $customer) {
    $name = $customer->CustomerName;
    $city = $customer->City;
}
```

Read more about lazy paginations on the [Saloon documentation](https://docs.saloon.dev/installable-plugins/pagination#using-the-paginator).

<a name="usage-extends"></a>

### Extending the SDK

You may easily extend the SDK by creating your own Resources, Requests, and Entities.

Then, by extending the `AteraConnector` class, add you new resources to the connector :

```php
use BlueRockTEL\AteraClient\AteraConnector;

class MyCustomConnector extends AteraConnector
{
    public function defaultConfig(): array
    {
        return [
            'timeout' => 120,
        ];
    }

    public function customResource(): \App\Resources\CustomResource
    {
        return new \App\Resources\CustomResource($this);
    }
}

$api = new MyCustomConnector('secret_token');
$api->customResource()->index();
```
