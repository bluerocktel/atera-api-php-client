<?php

namespace BlueRockTEL\AteraClient\Resources;

use Saloon\Http\Response;
use BlueRockTEL\AteraClient\Entities\Customer;
use BlueRockTEL\AteraClient\Endpoints\Customers as Endpoints;

class CustomerResource extends Resource
{
    public function index(
        int $page = 1,
        int $perPage = 20,
        array $query = [],
    ): Response {
        return $this->connector->send(
            new Endpoints\GetCustomersRequest(
                page: $page,
                perPage: $perPage,
                params: $query,
            )
        );
    }

    public function show(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\GetCustomerRequest($id)
        );
    }

    public function store(Customer $customer): Response
    {
        return $this->connector->send(
            new Endpoints\CreateCustomerRequest($customer)
        );
    }

    public function update(Customer $customer): Response
    {
        return $this->connector->send(
            new Endpoints\UpdateCustomerRequest($customer)
        );
    }

    public function upsert(Customer $customer): Response
    {
        return $customer->CustomerID
            ? $this->update($customer)
            : $this->store($customer);
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\DeleteCustomerRequest($id)
        );
    }
}