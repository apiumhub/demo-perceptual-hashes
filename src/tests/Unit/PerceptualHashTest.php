<?php

namespace UnitTests;

use App\Catalog;
use App\PerceptualHash;
use Jenssegers\ImageHash\ImageHash;
use PHPUnit\Framework\TestCase;

final class PerceptualHashTest extends TestCase
{
    /**
     * @test
     * @covers PerceptualHash
     * @dataProvider dataProviderCatalogs
     */
    public function can_accept_any_catalog(Catalog $catalog): void
    {
        $sut = new PerceptualHash($catalog);

        $this->assertInstanceOf(PerceptualHash::class, $sut);
        $this->assertInstanceOf(ImageHash::class, $sut->hasher);
    }

    public function dataProviderCatalogs(): array
    {
        return [
            [
                new Catalog()
            ],
            [
                (new Catalog())
                    ->add('./public/img/catalog/4-BONNIE-53O-BLPG_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-BLPG_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-FURD_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-TQGR_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-WHGD_2.jpg')
                    ->add('./public/img/catalog/4-BOURBO-47O-BKBZ_2.jpg')
            ],
        ];
    }

    /**
     * @test
     * @covers PerceptualHash
     * @dataProvider dataProviderContents
     */
    public function can_retrieve_contents(Catalog $catalog, int $expectedHash, int $expectedDistance): void
    {
        $sut = new PerceptualHash($catalog);

        $contents = $sut(
            filename: './public/img/tests/test-1.jpg',
            sort: SORT_ASC
        );

        $this->assertInstanceOf(Catalog::class, $contents);
        $this->assertCount(1, $contents->list);
        $this->assertArrayHasKey('path', $contents->list[0]);
        $this->assertArrayHasKey('hash', $contents->list[0]);
        $this->assertArrayHasKey('distance', $contents->list[0]);
        $this->assertEquals($expectedHash, $contents->list[0]['hash']);
        $this->assertEquals($expectedDistance, $contents->list[0]['distance']);
    }

    public function dataProviderContents(): array
    {
        return [
            [
                (new Catalog())->add('./public/img/catalog/4-BOURBO-47O-BKBZ_2.jpg'),
                878522138624,
                6,
            ],
            [
                (new Catalog())->add('./public/img/catalog/4-BONNIE-53O-WHGD_2.jpg'),
                930095300608,
                7,
            ],
            [
                (new Catalog())->add('./public/img/catalog/4-BONNIE-53O-BLPG_2.jpg'),
                878555693056,
                7,
            ],
            [
                (new Catalog())->add('./public/img/catalog/4-BONNIE-53O-TQGR_2.jpg'),
                612502601728,
                9,
            ],
        ];
    }

    /**
     * @test
     * @covers PerceptualHash
     * @dataProvider dataProviderDistances
     */
    public function can_sort_asc_by_distance(Catalog $catalog): void
    {
        $sut = new PerceptualHash($catalog);

        $contents = $sut(
            filename: './public/img/tests/test-1.jpg',
            sort: SORT_ASC
        );

        $this->assertInstanceOf(Catalog::class, $contents);
        $this->assertLessThanOrEqual($contents->list[1]['distance'], $contents->list[0]['distance']);
    }

    /**
     * @test
     * @covers PerceptualHash
     * @dataProvider dataProviderDistances
     */
    public function can_sort_desc_by_distance(Catalog $catalog): void
    {
        $sut = new PerceptualHash($catalog);

        $contents = $sut(
            filename: './public/img/tests/test-1.jpg',
            sort: SORT_DESC
        );

        $this->assertInstanceOf(Catalog::class, $contents);
        $this->assertGreaterThanOrEqual($contents->list[1]['distance'], $contents->list[0]['distance']);
    }

    public function dataProviderDistances(): array
    {
        return [
            [
                // Same distance
                (new Catalog())
                    ->add('./public/img/catalog/4-BONNIE-53O-BLPG_2.jpg')
                    ->add('./public/img/catalog/4-BOURBO-47O-BKBZ_2.jpg')
            ],
            [
                // Different distance
                (new Catalog())
                    ->add('./public/img/catalog/4-BONNIE-53O-WHGD_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-TQGR_2.jpg')
            ],
        ];
    }
}
