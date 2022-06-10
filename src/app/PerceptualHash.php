<?php

namespace App;

use Jenssegers\ImageHash\Hash;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;

final class PerceptualHash
{
    private ImageHash $hasher;

    private array $catalog;

    public function __construct(array $catalog)
    {
        $this->hasher  = new ImageHash(new DifferenceHash());
        $this->catalog = $catalog;
    }

    public function __invoke(string $filename, ?int $sort = SORT_ASC): array
    {
        $this->addHashesToCatalog();

        $this->calculateDistanceTo($this->hasher->hash($filename));

        $this->sortCatalogByDistance($sort);

        return $this->catalog;
    }

    // @TODO Catalog should contain image path + image hash (due hashes are inmutables)
    private function addHashesToCatalog()
    {
        array_map(function ($key, $entry) {
            $this->catalog[$key]['hash'] = $this->hasher->hash($entry['path'])->toInt();
        }, array_keys($this->catalog), $this->catalog);
    }

    private function calculateDistanceTo(Hash $hash): void
    {
        array_map(function ($key, $entry) use ($hash) {
            $this->catalog[$key]['distance'] = $this->hasher->distance($hash, Hash::fromInt($entry['hash']));
        }, array_keys($this->catalog), $this->catalog);
    }

    private function sortCatalogByDistance(?int $sort = SORT_ASC): void
    {
        array_multisort(array_column($this->catalog, 'distance'), $sort, $this->catalog);
    }
}
