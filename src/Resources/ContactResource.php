<?php

namespace BlueRockTEL\AteraClient\Resources;

use Saloon\Http\Response;
use BlueRockTEL\AteraClient\Entities\Contact;
use BlueRockTEL\AteraClient\Endpoints\Contacts as Endpoints;

class ContactResource extends Resource
{
    public function index(
        int $page = 1,
        int $perPage = 20,
        array $query = [],
    ): Response {
        return $this->connector->send(
            new Endpoints\GetContactsRequest(
                page: $page,
                perPage: $perPage,
                params: $query,
            )
        );
    }

    public function show(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\GetContactRequest($id)
        );
    }

    public function store(Contact $contact): Response
    {
        return $this->connector->send(
            new Endpoints\CreateContactRequest($contact)
        );
    }

    public function update(Contact $contact): Response
    {
        return $this->connector->send(
            new Endpoints\UpdateContactRequest($contact)
        );
    }

    public function upsert(Contact $contact): Response
    {
        return $contact->EndUserID
            ? $this->update($contact)
            : $this->store($contact);
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\DeleteContactRequest($id)
        );
    }

    public function searchByPhone(
        string $phoneNumber,
        array $query = [],
    ): Response {
        return $this->index(
            query: [
                'searchOptions.phone' => $phoneNumber,
                ...$query,
            ],
        );
    }

    public function searchByEmail(
        string $emailAddress,
        array $query = [],
    ): Response {
        return $this->index(
            query: [
                'searchOptions.email' => $emailAddress,
                ...$query,
            ],
        );
    }
}