<?php

namespace App;

final class Catalog
{
    public array $list;

    public function __construct()
    {
        $this->list = [];
    }

    public function add(string $path): self
    {
        $this->list[] = [
            'path' => $path,
        ];

        return $this;
    }

    public function setHash(int $key, int $value): self
    {
        return $this->set($key, 'hash', $value);
    }

    public function setDistance(int $key, int $value): self
    {
        return $this->set($key, 'distance', $value);
    }

    public function sortByDistance(?int $sort = SORT_ASC): self
    {
        array_multisort(array_column($this->list, 'distance'), $sort, $this->list);

        return $this;
    }

    private function set(int $index, string $key, int $value): self
    {
        $this->list[$index][$key] = $value;

        return $this;
    }
}
