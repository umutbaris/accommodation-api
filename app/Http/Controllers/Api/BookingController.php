<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\CreateBookingRequest;
use App\Repositories\BaseRepository;
use App\Repositories\BookingRepository;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

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

    /**
     * @var BookingService
     */
    protected $bookingService;

    /**
     * @var
     */
    protected $baseRepository;


    /**
     * BookingController constructor.
     *
     * @param  BookingRepository  $bookingRepository
     * @param  BookingService  $bookingService
     * @param  BaseRepository  $baseRepository
     */
    public function __construct(BookingRepository $bookingRepository, BookingService $bookingService, BaseRepository $baseRepository)
    {
        parent::__construct($baseRepository);
        $this->bookingRepository = $bookingRepository;
        $this->bookingService = $bookingService;
    }

    /**
     * Create new entries
     *
     * @param  CreateBookingRequest  $request
     * @return JsonResponse
     */
    public function create(CreateBookingRequest $request): JsonResponse
    {
        if(!$this->bookingService->checkAvailability($request->get('hotel_id'))){
            return $this->sendError('There Is No Availability');
        }
        $booking = $this->bookingRepository->store($request->all());

        return $this->sendSuccess($booking, 201);
    }

}