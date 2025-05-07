<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function findByField(string $field, string $value);

    public function getByFields(array $fields);

    public function newItem(array $data);

    public function updateItem(string $id, array $data);

    public function deleteItem(string $id);
}
