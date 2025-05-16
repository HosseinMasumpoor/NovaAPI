<?php

namespace App\Core\Queue\Interfaces;

interface QueueRepositoryInterface
{
    public function store(string $serializedJob): void;
    public function getNext(): ?array;
    public function delete(int $id): void;
}
