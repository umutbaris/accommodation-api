<?php


namespace App\Services;


use App\Repositories\HotelRepository;

class BookingService
{
    /**
     * @var HotelRepository
     */
    protected $hotelRepository;


    /**
     * BookingService constructor.
     * @param  HotelRepository  $hotelRepository
     */
    public function __construct(HotelRepository $hotelRepository)
    {
        $this->hotelRepository = $hotelRepository;
    }

    /**
     * Check enough reservation availability
     *
     * @param  int  $hotelId
     * @return bool
     */
    public function checkAvailability(int $hotelId): bool
    {
        $exist = false;
        if(isset($this->hotelRepository->find($hotelId)->availability)) {
            $availability = $this->hotelRepository->find($hotelId)->availability;
            if ($availability > 0) {
                $this->updateAvailability($hotelId, $availability);
                $exist = true;
            }
        }

        return $exist;
    }

    /**
     * Decrease reservation availability for successful booking
     *
     * @param  int  $hotelId
     * @param  int  $availability
     */
    public function updateAvailability(int $hotelId, int $availability): void
    {
        $this->hotelRepository->update($hotelId, ['availability' => $availability - 1]);
    }
}