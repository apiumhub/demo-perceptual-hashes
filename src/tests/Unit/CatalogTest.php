<?php

namespace UnitTests;

use App\Catalog;
use PHPUnit\Framework\TestCase;

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
     * @test
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::set
     * @dataProvider dataProviderCatalog
     */
    public function instanceIsConsistent(
        array $expectedPaths,
        array $expectedHashes,
        array $expectedDistances
    ): void {
        $this->assertInstanceOf(Catalog::class, $this->catalog);
        $this->assertIsArray($this->catalog->list);
        $this->assertCount(3, $this->catalog->list);

        foreach ($this->catalog->list as $entry) {
            $this->assertArrayHasKey('path', $entry);
            $this->assertArrayHasKey('hash', $entry);
            $this->assertArrayHasKey('distance', $entry);
        }
    }

    /**
     * @test
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::set
     * @dataProvider dataProviderCatalog
     */
    public function instanceHasValidPathes(
        array $expectedPaths,
        array $expectedHashes,
        array $expectedDistances
    ): void {
        foreach ($expectedPaths as $key => $expected) {
            $this->assertEquals($expected, $this->catalog->list[$key]['path']);
        }
    }

    /**
     * @test
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::set
     * @dataProvider dataProviderCatalog
     */
    public function instanceHasValidHashes(
        array $expectedPaths,
        array $expectedHashes,
        array $expectedDistances
    ): void {
        foreach ($expectedHashes as $key => $expected) {
            $this->assertEquals($expected, $this->catalog->list[$key]['hash']);
        }
    }

    /**
     * @test
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::set
     * @dataProvider dataProviderCatalog
     */
    public function instanceHashValidDistances(
        array $expectedPaths,
        array $expectedHashes,
        array $expectedDistances
    ): void {
        foreach ($expectedDistances as $key => $expected) {
            $this->assertEquals($expected, $this->catalog->list[$key]['distance']);
        }
    }

    /**
     * @test
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::set
     * @covers \App\Catalog::sortByDistance
     */
    public function canBeSortedByDistanceAsc(): void
    {
        $this->catalog->sortByDistance(SORT_ASC);

        $this->assertLessThanOrEqual(
            $this->catalog->list[2]['distance'],
            $this->catalog->list[0]['distance']
        );
    }

    /**
     * @test
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::set
     * @covers \App\Catalog::sortByDistance
     */
    public function canBeSortedByDistanceDesc(): void
    {
        $this->catalog->sortByDistance(SORT_DESC);

        $this->assertGreaterThanOrEqual(
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
