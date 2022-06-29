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
        $this->assertArrayHasKey('path', $catalog->list[0]);
        $this->assertArrayHasKey('path', $catalog->list[1]);
        $this->assertArrayHasKey('path', $catalog->list[2]);
    }

    /**
     * @test
     * @covers Catalog
     * @dataProvider dataProviderCatalog
     */
    public function can_set_hash(Catalog $catalog): void
    {
        $this->assertInstanceOf(Catalog::class, $catalog);
        $this->assertIsArray($catalog->list);
        $this->assertCount(3, $catalog->list);
        $this->assertArrayHasKey('hash', $catalog->list[1]);
        $this->assertEquals(2, $catalog->list[1]['hash']);
    }

    /**
     * @test
     * @covers Catalog
     * @dataProvider dataProviderCatalog
     */
    public function can_set_distance(Catalog $catalog): void
    {
        $this->assertInstanceOf(Catalog::class, $catalog);
        $this->assertIsArray($catalog->list);
        $this->assertCount(3, $catalog->list);
        $this->assertArrayHasKey('distance', $catalog->list[1]);
        $this->assertEquals(20, $catalog->list[1]['distance']);
    }

    /**
     * @test
     * @covers Catalog
     * @dataProvider dataProviderCatalog
     */
    public function can_sort_asc_by_distance(Catalog $catalog): void
    {
        $catalog->sortByDistance(SORT_ASC);

        $this->assertInstanceOf(Catalog::class, $catalog);
        $this->assertIsArray($catalog->list);
        $this->assertCount(3, $catalog->list);
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

        $this->assertInstanceOf(Catalog::class, $catalog);
        $this->assertIsArray($catalog->list);
        $this->assertCount(3, $catalog->list);
        $this->assertGreaterThanOrEqual($catalog->list[2]['distance'], $catalog->list[0]['distance']);
    }

    public function dataProviderCatalog(): array
    {
        return [
            [
                (new Catalog())
                    ->add('xxx')->setHash(0, 1)->setDistance(0, 10)
                    ->add('yyy')->setHash(1, 2)->setDistance(1, 20)
                    ->add('zzz')->setHash(2, 3)->setDistance(2, 30)
            ]
        ];
    }
}
