<?php

namespace UnitTests;

use App\Catalog;
use PHPUnit\Framework\TestCase;

final class CatalogTest extends TestCase
{
    /**
     * @test
     * @covers Catalog
     * @dataProvider dataProviderCatalog
     */
    public function can_contain_entries(Catalog $catalog): void
    {
        $this->assertInstanceOf(Catalog::class, $catalog);
        $this->assertIsArray($catalog->list);
        $this->assertCount(3, $catalog->list);

        foreach ([0 => 'xxx', 1 => 'yyy', 2 => 'zzz'] as $key => $expected) {
            $this->assertArrayHasKey('path', $catalog->list[$key]);
            $this->assertEquals($expected, $catalog->list[$key]['path']);
        }
    }

    /**
     * @test
     * @covers Catalog
     * @dataProvider dataProviderCatalog
     */
    public function can_set_hash(Catalog $catalog): void
    {
        foreach ([0 => 1, 1 => 2, 2 => 3] as $key => $expected) {
            $this->assertArrayHasKey('hash', $catalog->list[$key]);
            $this->assertEquals($expected, $catalog->list[$key]['hash']);
        }
    }

    /**
     * @test
     * @covers Catalog
     * @dataProvider dataProviderCatalog
     */
    public function can_set_distance(Catalog $catalog): void
    {
        foreach ([0 => 100, 1 => 200, 2 => 300] as $key => $expected) {
            $this->assertArrayHasKey('distance', $catalog->list[$key]);
            $this->assertEquals($expected, $catalog->list[$key]['distance']);
        }
    }

    /**
     * @test
     * @covers Catalog
     * @dataProvider dataProviderCatalog
     */
    public function can_sort_asc_by_distance(Catalog $catalog): void
    {
        $catalog->sortByDistance(SORT_ASC);

        $this->assertLessThanOrEqual($catalog->list[2]['distance'], $catalog->list[0]['distance']);
    }

    /**
     * @test
     * @covers Catalog
     * @dataProvider dataProviderCatalog
     */
    public function can_sort_desc_by_distance(Catalog $catalog): void
    {
        $catalog->sortByDistance(SORT_DESC);

        $this->assertGreaterThanOrEqual($catalog->list[2]['distance'], $catalog->list[0]['distance']);
    }

    public function dataProviderCatalog(): array
    {
        return [
            [
                (new Catalog())
                    ->add('xxx')->setHash(0, 1)->setDistance(0, 100)
                    ->add('yyy')->setHash(1, 2)->setDistance(1, 200)
                    ->add('zzz')->setHash(2, 3)->setDistance(2, 300)
            ]
        ];
    }
}
