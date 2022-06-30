<?php

namespace UnitTests;

use App\Catalog;
use App\DirectoryLoader;
use PHPUnit\Framework\TestCase;

final class DirectoryLoaderTest extends TestCase
{
    /**
     * @test
     * @covers DirectoryLoader
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
     * @covers DirectoryLoader
     * @dataProvider dataProviderContents
     */
    public function instanceCanRetrieveFilteredContents(string $pattern, int $expected): void
    {
        $loader = new DirectoryLoader($pattern);

        $catalog = $loader();

        $this->assertInstanceOf(Catalog::class, $catalog);
        $this->assertCount($expected, $catalog->list);
    }

    public function dataProviderContents(): array
    {
        return [
            ['', 0],
            ['.', 1],
            ['./.gitignore', 1],
            ['./*.xml', 1],
        ];
    }

    /**
     * @test
     * @covers DirectoryLoader
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
            ['./*.xml', 1, 'phpunit.xml'],
        ];
    }
}
