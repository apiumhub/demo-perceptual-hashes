<?php

namespace App;

use Jenssegers\ImageHash\Hash;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;

final class PerceptualHash
{
    public readonly ImageHash $hasher;

    private Catalog $catalog;

    public function __construct(Catalog $catalog)
    {
        $this->hasher = new ImageHash(new DifferenceHash());
        $this->catalog = $catalog;
    }

    public function __invoke(string $filename, ?int $sort = SORT_ASC): Catalog
    {
        $this->addHashesToCatalog();

        $this->calculateDistanceAgainst($this->hasher->hash($filename));

        return $this->catalog->sortByDistance($sort);
    }

    /** @TODO Catalog should contain image path + image hash (due hashes are inmutables) */
    private function addHashesToCatalog()
    {
        array_map(function ($key, $entry) {
            $this->catalog->setHash(
                key: $key,
                value: $this->hasher->hash($entry['path'])->toInt()
            );
        }, array_keys($this->catalog->list), $this->catalog->list);
    }

    private function calculateDistanceAgainst(Hash $hash): void
    {
        array_map(function ($key, $entry) use ($hash) {
            $this->catalog->setDistance(
                key: $key,
                value: $this->hasher->distance($hash, Hash::fromInt($entry['hash']))
            );
        }, array_keys($this->catalog->list), $this->catalog->list);
    }
}
