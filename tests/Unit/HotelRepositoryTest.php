<?php

namespace Tests\Unit;

use App\Repositories\BaseRepository;
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
        $hotelRepository = new HotelRepository();
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
        $hotelRepository = new HotelRepository();
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
        $hotelRepository = new HotelRepository();
        $result = $hotelRepository->calculateReputationBadge(700);
        $this->assertEquals('yellow', $result);
    }
}
