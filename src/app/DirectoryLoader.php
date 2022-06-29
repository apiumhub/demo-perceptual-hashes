<?php

namespace App;

use App\Catalog;

final class DirectoryLoader
{
    public function __construct(
        private ?string $pattern = ''
    ) {}

    public function __invoke(): Catalog
    {
        $catalog = new Catalog();

        array_map(function ($path) use ($catalog) {
            $catalog->add($path);
        }, glob($this->pattern));

        return $catalog;
    }
}
