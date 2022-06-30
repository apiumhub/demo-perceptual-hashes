<?php

namespace UnitTests;

use App\Catalog;
use App\DirectoryLoader;
use PHPUnit\Framework\TestCase;

final class DirectoryLoaderTest extends TestCase
{
    /**
     * @test
     * @covers \App\DirectoryLoader::__construct
     * @covers \App\DirectoryLoader::__invoke
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @dataProvider dataProviderPatterns
     */
    public function instanceIsConsistent(string $pattern): void
    {
        $loader = new DirectoryLoader($pattern);

        $catalog = $loader();

        $this->assertInstanceOf(DirectoryLoader::class, $loader);
        $this->assertInstanceOf(Catalog::class, $catalog);
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
     * @test
     * @covers \App\DirectoryLoader::__construct
     * @covers \App\DirectoryLoader::__invoke
     * @covers \App\Catalog::__construct
     * @dataProvider dataProviderContentsNoAnyResult
     */
    public function instanceCanRetrieveFilteredContentsNoAnyResult(string $pattern, int $expected): void
    {
        $loader = new DirectoryLoader($pattern);

        $catalog = $loader();

        $this->assertInstanceOf(Catalog::class, $catalog);
        $this->assertCount($expected, $catalog->list);
    }

    public function dataProviderContentsNoAnyResult(): array
    {
        return [
            ['', 0],
        ];
    }

    /**
     * @test
     * @covers \App\DirectoryLoader::__construct
     * @covers \App\DirectoryLoader::__invoke
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @dataProvider dataProviderContentsMatchedResults
     */
    public function instanceCanRetrieveFilteredContentsMatchedResults(string $pattern, int $expected): void
    {
        $loader = new DirectoryLoader($pattern);

        $catalog = $loader();

        $this->assertInstanceOf(Catalog::class, $catalog);
        $this->assertCount($expected, $catalog->list);
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
     * @test
     * @covers \App\DirectoryLoader::__construct
     * @covers \App\DirectoryLoader::__invoke
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @dataProvider dataProviderCatalogStructure
     */
    public function instanceReturnsValidCatalog(string $pattern, int $expectedMatches, string $filename): void
    {
        $loader = new DirectoryLoader($pattern);

        $catalog = $loader();

        $this->assertInstanceOf(Catalog::class, $catalog);
        $this->assertCount($expectedMatches, $catalog->list);
        $this->assertArrayHasKey('path', $catalog->list[0]);
        $this->assertStringEndsWith($filename, $catalog->list[0]['path']);
    }

    public function dataProviderCatalogStructure(): array
    {
        return [
            ['./.gitignore', 1, '.gitignore'],
            ['./*.lock', 1, 'composer.lock'],
        ];
    }
}
