<?php

namespace UnitTests;

use App\Catalog;
use App\PerceptualHash;
use Jenssegers\ImageHash\ImageHash;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class PerceptualHashTest extends TestCase
{
    /**
     * @covers \App\PerceptualHash::__construct
     * @dataProvider dataProviderCatalogs
     */
    public function testInstanceIsConsistent(Catalog $catalog): void
    {
        $sut = new PerceptualHash($catalog);

        static::assertInstanceOf(PerceptualHash::class, $sut);
        static::assertInstanceOf(ImageHash::class, $sut->hasher);
    }

    public function dataProviderCatalogs(): array
    {
        return [
            [
                new Catalog(),
            ],
            [
                (new Catalog())
                    ->add('./public/img/catalog/4-BONNIE-53O-BLPG_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-BLPG_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-FURD_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-TQGR_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-WHGD_2.jpg')
                    ->add('./public/img/catalog/4-BOURBO-47O-BKBZ_2.jpg'),
            ],
        ];
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::set
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::sortByDistance
     * @covers \App\PerceptualHash::__construct
     * @covers \App\PerceptualHash::__invoke
     * @covers \App\PerceptualHash::addHashesToCatalog
     * @covers \App\PerceptualHash::calculateDistanceAgainst
     * @dataProvider dataProviderCatalogContents
     */
    public function testInstanceReturnsValidCatalog(
        Catalog $catalog,
        string $expectedSuffixPath,
        int $expectedHash,
        int $expectedDistance
    ): void {
        $sut = new PerceptualHash($catalog);

        $contents = $sut(
            filename: './public/img/tests/test-1.jpg',
            sort: SORT_ASC
        );

        static::assertInstanceOf(Catalog::class, $contents);
        static::assertCount(1, $contents->list);
        static::assertArrayHasKey('path', $contents->list[0]);
        static::assertArrayHasKey('hash', $contents->list[0]);
        static::assertArrayHasKey('distance', $contents->list[0]);
        static::assertStringEndsWith($expectedSuffixPath, $catalog->list[0]['path']);
        static::assertSame($expectedHash, $contents->list[0]['hash']);
        static::assertSame($expectedDistance, $contents->list[0]['distance']);
    }

    public function dataProviderCatalogContents(): array
    {
        return [
            [
                (new Catalog())->add('./public/img/catalog/4-BOURBO-47O-BKBZ_2.jpg'),
                '4-BOURBO-47O-BKBZ_2.jpg',
                878522138624,
                6,
            ],
            [
                (new Catalog())->add('./public/img/catalog/4-BONNIE-53O-WHGD_2.jpg'),
                '4-BONNIE-53O-WHGD_2.jpg',
                930095300608,
                7,
            ],
            [
                (new Catalog())->add('./public/img/catalog/4-BONNIE-53O-BLPG_2.jpg'),
                '4-BONNIE-53O-BLPG_2.jpg',
                878555693056,
                7,
            ],
            [
                (new Catalog())->add('./public/img/catalog/4-BONNIE-53O-TQGR_2.jpg'),
                '4-BONNIE-53O-TQGR_2.jpg',
                612502601728,
                9,
            ],
        ];
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::set
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::sortByDistance
     * @covers \App\PerceptualHash::__construct
     * @covers \App\PerceptualHash::__invoke
     * @covers \App\PerceptualHash::addHashesToCatalog
     * @covers \App\PerceptualHash::calculateDistanceAgainst
     * @dataProvider dataProviderCatalogDistances
     */
    public function testCatalogCanBeSortedByDistanceAsc(Catalog $catalog): void
    {
        $sut = new PerceptualHash($catalog);

        $contents = $sut(
            filename: './public/img/tests/test-1.jpg',
            sort: SORT_ASC
        );

        static::assertInstanceOf(Catalog::class, $contents);
        static::assertLessThanOrEqual($contents->list[1]['distance'], $contents->list[0]['distance']);
    }

    /**
     * @covers \App\Catalog::__construct
     * @covers \App\Catalog::add
     * @covers \App\Catalog::set
     * @covers \App\Catalog::setDistance
     * @covers \App\Catalog::setHash
     * @covers \App\Catalog::sortByDistance
     * @covers \App\PerceptualHash::__construct
     * @covers \App\PerceptualHash::__invoke
     * @covers \App\PerceptualHash::addHashesToCatalog
     * @covers \App\PerceptualHash::calculateDistanceAgainst
     * @dataProvider dataProviderCatalogDistances
     */
    public function testCatalogCanBeSortedByDistanceDesc(Catalog $catalog): void
    {
        $sut = new PerceptualHash($catalog);

        $contents = $sut(
            filename: './public/img/tests/test-1.jpg',
            sort: SORT_DESC
        );

        static::assertInstanceOf(Catalog::class, $contents);
        static::assertGreaterThanOrEqual($contents->list[1]['distance'], $contents->list[0]['distance']);
    }

    public function dataProviderCatalogDistances(): array
    {
        return [
            [
                // Same distance
                (new Catalog())
                    ->add('./public/img/catalog/4-BONNIE-53O-BLPG_2.jpg')
                    ->add('./public/img/catalog/4-BOURBO-47O-BKBZ_2.jpg'),
            ],
            [
                // Different distance
                (new Catalog())
                    ->add('./public/img/catalog/4-BONNIE-53O-WHGD_2.jpg')
                    ->add('./public/img/catalog/4-BONNIE-53O-TQGR_2.jpg'),
            ],
        ];
    }
}
