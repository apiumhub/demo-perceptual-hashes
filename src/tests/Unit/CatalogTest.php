<?php

namespace UnitTests;

use App\Catalog;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CatalogTest extends TestCase
{
    private Catalog $catalog;

    protected function setUp(): void
    {
        $this->catalog = (new Catalog())
            ->add('xxx')->setHash(0, 1)->setDistance(0, 100)
            ->add('yyy')->setHash(1, 2)->setDistance(1, 200)
            ->add('zzz')->setHash(2, 3)->setDistance(2, 300);
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::set
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::setHash
     * @dataProvider dataProviderCatalog
     */
    public function testInstanceIsConsistent(
        array $expectedPaths,
        array $expectedHashes,
        array $expectedDistances
    ): void {
        static::assertInstanceOf(Catalog::class, $this->catalog);
        static::assertIsArray($this->catalog->list);
        static::assertCount(3, $this->catalog->list);

        foreach ($this->catalog->list as $entry) {
            static::assertArrayHasKey('path', $entry);
            static::assertArrayHasKey('hash', $entry);
            static::assertArrayHasKey('distance', $entry);
        }
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::set
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::setHash
     * @dataProvider dataProviderCatalog
     */
    public function testInstanceHasValidPathes(
        array $expectedPaths,
        array $expectedHashes,
        array $expectedDistances
    ): void {
        foreach ($expectedPaths as $key => $expected) {
            static::assertSame($expected, $this->catalog->list[$key]['path']);
        }
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::set
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::setHash
     * @dataProvider dataProviderCatalog
     */
    public function testInstanceHasValidHashes(
        array $expectedPaths,
        array $expectedHashes,
        array $expectedDistances
    ): void {
        foreach ($expectedHashes as $key => $expected) {
            static::assertSame($expected, $this->catalog->list[$key]['hash']);
        }
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::set
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::setHash
     * @dataProvider dataProviderCatalog
     */
    public function testInstanceHashValidDistances(
        array $expectedPaths,
        array $expectedHashes,
        array $expectedDistances
    ): void {
        foreach ($expectedDistances as $key => $expected) {
            static::assertSame($expected, $this->catalog->list[$key]['distance']);
        }
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::set
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::sortByDistance
     */
    public function testCanBeSortedByDistanceAsc(): void
    {
        $this->catalog->sortByDistance(SORT_ASC);

        static::assertLessThanOrEqual(
            $this->catalog->list[2]['distance'],
            $this->catalog->list[0]['distance']
        );
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::set
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::sortByDistance
     */
    public function testCanBeSortedByDistanceDesc(): void
    {
        $this->catalog->sortByDistance(SORT_DESC);

        static::assertGreaterThanOrEqual(
            $this->catalog->list[2]['distance'],
            $this->catalog->list[0]['distance']
        );
    }

    public function dataProviderCatalog(): array
    {
        return [
            [
                ['xxx', 'yyy', 'zzz'],
                [1, 2, 3],
                [100, 200, 300],
            ],
        ];
    }
}
