<?php

namespace UnitTests;

use App\Catalog;
use App\DirectoryLoader;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class DirectoryLoaderTest extends TestCase
{
    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\DirectoryLoader::__construct
     * @covers \App\DirectoryLoader::__invoke
     * @dataProvider dataProviderPatterns
     */
    public function testInstanceIsConsistent(string $pattern): void
    {
        $loader = new DirectoryLoader($pattern);

        $catalog = $loader();

        static::assertInstanceOf(DirectoryLoader::class, $loader);
        static::assertInstanceOf(Catalog::class, $catalog);
    }

    public function dataProviderPatterns(): array
    {
        return [
            [''],
            ['.'],
            ['./*.jpg'],
        ];
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\DirectoryLoader::__construct
     * @covers \App\DirectoryLoader::__invoke
     * @dataProvider dataProviderContentsNoAnyResult
     */
    public function testInstanceCanRetrieveFilteredContentsNoAnyResult(string $pattern, int $expected): void
    {
        $loader = new DirectoryLoader($pattern);

        $catalog = $loader();

        static::assertInstanceOf(Catalog::class, $catalog);
        static::assertCount($expected, $catalog->list);
    }

    public function dataProviderContentsNoAnyResult(): array
    {
        return [
            ['', 0],
        ];
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\DirectoryLoader::__construct
     * @covers \App\DirectoryLoader::__invoke
     * @dataProvider dataProviderContentsMatchedResults
     */
    public function testInstanceCanRetrieveFilteredContentsMatchedResults(string $pattern, int $expected): void
    {
        $loader = new DirectoryLoader($pattern);

        $catalog = $loader();

        static::assertInstanceOf(Catalog::class, $catalog);
        static::assertCount($expected, $catalog->list);
    }

    public function dataProviderContentsMatchedResults(): array
    {
        return [
            ['.', 1],
            ['./.gitignore', 1],
            ['./*.lock', 1],
        ];
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\DirectoryLoader::__construct
     * @covers \App\DirectoryLoader::__invoke
     * @dataProvider dataProviderCatalogStructure
     */
    public function testInstanceReturnsValidCatalog(string $pattern, int $expectedMatches, string $filename): void
    {
        $loader = new DirectoryLoader($pattern);

        $catalog = $loader();

        static::assertInstanceOf(Catalog::class, $catalog);
        static::assertCount($expectedMatches, $catalog->list);
        static::assertArrayHasKey('path', $catalog->list[0]);
        static::assertStringEndsWith($filename, $catalog->list[0]['path']);
    }

    public function dataProviderCatalogStructure(): array
    {
        return [
            ['./.gitignore', 1, '.gitignore'],
            ['./*.lock', 1, 'composer.lock'],
        ];
    }
}
