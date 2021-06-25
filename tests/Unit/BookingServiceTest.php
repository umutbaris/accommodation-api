<?php

namespace Tests\Unit;

use App\Repositories\HotelRepository;
use App\Services\BookingService;
use Tests\TestCase;

class BookingServiceTest extends  TestCase
{
    /**
     * A unit test for Hotel has availability for reservation
     *
     * @return void
     */
    public function testCheckAvailabilityForAvailable()
    {
        $hotelRepository = $this->createMock(HotelRepository::class);
        $hotelRepository->method('find')
            ->willReturn((object)['availability'=>1]);

        $bookingService = new BookingService($hotelRepository);
        $result = $bookingService->checkAvailability(1);
        $this->assertTrue($result);
    }

    /**
     * A unit test for Hotel dont have availability for reservation
     *
     * @return void
     */
    public function testCheckAvailabilityNonAvailable()
    {
        $hotelRepository = $this->createMock(HotelRepository::class);
        $hotelRepository->method('find')
            ->willReturn((object)['availability'=> 0]);

        $bookingService = new BookingService($hotelRepository);
        $result = $bookingService->checkAvailability(1);
        $this->assertFalse($result);
    }
}
