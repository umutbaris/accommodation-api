<?php

namespace Tests\Unit;

use App\Repositories\CategoryRepository;
use App\Repositories\HotelRepository;
use PHPUnit\Framework\TestCase;

class HotelRepositoryTest extends TestCase
{
    /**
     * Unit Test Calculating ReputationBadges For Red Values
     *
     *
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
     *
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
     *
     */
    public function testCalculateReputationBadgeGreen()
    {
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $hotelRepository = new HotelRepository($categoryRepository);
        $result = $hotelRepository->calculateReputationBadge(700);

        $this->assertEquals('yellow', $result);
    }


    /**
     *  Test Sanitize Parameters
     *
     */
    public function testSanitizeParameters()
    {
        $parameters = [
            "max-availability" => "1",
            "city" => "Cuernavaca",
            "country" => "Germany"
        ];

        $expected =[
            "max-availability" => "1",
            "city" => "Cuernavaca"
        ];

        $categoryRepository = $this->createMock(CategoryRepository::class);
        $hotelRepository = new HotelRepository($categoryRepository);

        $result = $hotelRepository->sanitizeParameters($parameters);

        $this->assertEquals($expected, $result);
    }

    /**
     *  Test Sanitize Replace Category Key
     *
     */
    public function testReplaceCategoryKey ()
    {
        $slug = 'hotel';
        $hotelId = 1;
        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->getCategoryIdFromSlug($slug);

        $this->assertEquals($hotelId, $result);
    }
}
