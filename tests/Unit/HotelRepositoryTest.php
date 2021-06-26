<?php

namespace Tests\Unit;

use App\Repositories\BaseRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\HotelRepository;
use PHPUnit\Framework\TestCase;

class HotelRepositoryTest extends TestCase
{
    /**
     * Unit Test Calculating ReputationBadges For Red Values
     *
     * @return void
     */
    public function testCalculateReputationBadgeRed()
    {
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $hotelRepository = new HotelRepository($categoryRepository);
        $result = $hotelRepository->calculateReputationBadge(300);
        $this->assertEquals('red', $result);
    }

    /**
     * Unit Test Calculating ReputationBadges For Red Values
     *
     * @return void
     */
    public function testCalculateReputationBadgeYellow()
    {
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $hotelRepository = new HotelRepository($categoryRepository);
        $result = $hotelRepository->calculateReputationBadge(501);
        $this->assertEquals('yellow', $result);
    }

    /**
     * Unit Test Calculating ReputationBadges For Red Values
     *
     * @return void
     */
    public function testCalculateReputationBadgeGreen()
    {
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $hotelRepository = new HotelRepository($categoryRepository);
        $result = $hotelRepository->calculateReputationBadge(700);
        $this->assertEquals('yellow', $result);
    }
}
