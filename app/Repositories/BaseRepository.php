<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    protected string $model;

    private function query(): Builder
    {
        return (new $this->model)->query();
    }
    public function findByField(string $field, string $value)
    {
        return $this->query()->where($field, $value)->first();
    }

    public function getByFields(array $fields): Builder
    {
        $query = $this->query();
        foreach ($fields as $key => $value) {
            $query->where($key, $value);
        }
        return $query;
    }

    public function newItem(array $data): Model
    {
        return $this->model::create($data);
    }

    public function updateItem(string $id, array $data)
    {
        $item = $this->findByField('id', $id);
        foreach ($data as $key => $value) {
            $item->$key = $value;
        }
        return $item->save();
    }

    public function deleteItem(string $id)
    {
        $item = $this->findByField('id', $id);
        return $item->delete();
    }
}
