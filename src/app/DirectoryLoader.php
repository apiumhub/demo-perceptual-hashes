<?php

namespace App;

final class DirectoryLoader
{
    public function __construct(
        private string $pattern
    ) {}

    public function __invoke(): array
    {
        return array_map(function ($path) {
            return [
                'path' => $path,
            ];
        }, glob($this->pattern));
    }
}
