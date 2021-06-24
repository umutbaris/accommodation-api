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
    public function checkAvailability(int $hotelId)
    {
        $avilability = $this->hotelRepository->find($hotelId)->availability;
        if ($avilability < 1) {
            return false;
        }

        $this->updateAvailability($hotelId, $avilability);

        return true;
    }

    /**
     * Decrease reservation availability for successful booking
     *
     * @param  int  $hotelId
     * @param  int  $availability
     */
    public function updateAvailability(int $hotelId, int $availability)
    {
        $this->hotelRepository->update($hotelId, ['availability' => $availability - 1]);
    }


}