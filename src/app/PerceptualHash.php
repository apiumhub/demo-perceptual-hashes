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
        $this->calculateDistance($this->hasher->hash($filename));

        $this->sortCatalogByColumn('distance', $sort);

        return $this->catalog;
    }

    private function calculateDistance(Hash $testHash): void
    {
        array_map(function ($key, $entry) use ($testHash) {
            $entryHash = $this->hasher->hash($entry['path']);

            $this->catalog[$key]['distance'] = $this->hasher->distance($testHash, $entryHash);
        }, array_keys($this->catalog), $this->catalog);
    }

    private function sortCatalogByColumn(string $column, ?int $sort = SORT_ASC): void
    {
        array_multisort(array_column($this->catalog, $column), $sort, $this->catalog);
    }
}
