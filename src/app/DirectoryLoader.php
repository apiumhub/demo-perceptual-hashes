<?php

namespace App;

final class DirectoryLoader
{
    private array $list;

    public function __construct(string $pattern)
    {
        $this->list = [];

        $this->loadCatalog($pattern);
    }

    public function __invoke(): array
    {
        return $this->list;
    }

    private function loadCatalog(string $pattern): void
    {
        array_map(function ($path) {
            $this->list[] = [
                'path' => $path,
            ];
        }, glob($pattern));
    }
}
