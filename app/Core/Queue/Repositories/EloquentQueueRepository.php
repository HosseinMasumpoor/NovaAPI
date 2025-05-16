<?php

namespace App\Core\Queue\Repositories;

use App\Core\Queue\Interfaces\QueueRepositoryInterface;
use App\Core\Queue\Models\Job;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentQueueRepository implements QueueRepositoryInterface
{
    private string $model;
    public function __construct()
    {
        $this->model = Job::class;
    }

    private function query(): Builder
    {
        return $this->model::query();
    }

    public function store(string $serializedJob): void
    {
        $this->model::create([
            'job' => $serializedJob
        ]);
    }

    public function getNext(): ?array
    {
        return $this->query()->orderBy('id', 'asc')->limit(1)->first()?->toArray();
    }

    public function delete(int $id): void
    {
        $this->query()->where('id', $id)->delete();
    }
}
