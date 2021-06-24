<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\CreateBookingRequest;
use App\Repositories\BookingRepository;
use App\Services\BookingService;

/**
 * Class BookingController
 * @package App\Http\Controllers\Api
 */
class BookingController extends BaseApiController
{
    /**
     * @var BookingRepository
     */
    protected $bookingRepository;

    protected $bookingService;

    /**
     * BookingController constructor.
     * @param  BookingRepository  $bookingRepository
     * @param  BookingService  $bookingService
     */
    public function __construct(BookingRepository $bookingRepository, BookingService $bookingService )
    {
        $this->bookingRepository = $bookingRepository;
        $this->bookingService = $bookingService;
    }

    /**
     * Create new entries
     *
     * @param  CreateBookingRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateBookingRequest $request)
    {
        if(!$this->bookingService->checkAvailability($request->hotel_id)){
            return $this->sendError('There Is No Availability', 400);
        }
        $booking = $this->bookingRepository->store($request->all());

        return $this->sendSuccess($booking, 201);
    }

}