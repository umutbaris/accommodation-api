<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\CreateHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Repositories\BaseRepository;
use App\Repositories\HotelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HotelController extends BaseApiController
{
    /**
     * @var HotelRepository
     */
    protected $hotelRepository;

    /**
     * @var BaseRepository
     */
    protected $baseRepository;


    /**
     * HotelController constructor.
     * @param  HotelRepository  $hotelRepository
     * @param  BaseRepository  $baseRepository
     */
    public function __construct(HotelRepository $hotelRepository,  BaseRepository $baseRepository)
    {
        parent::__construct($baseRepository);
        $this->hotelRepository = $hotelRepository;
    }

    /**
     *
     * Get all the items for the given hotelier
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $hotels = Cache::remember('hotels' . $request->fullUrl() . $request->user()->id, 3600, function () use ($request)
        {
            if(isset($request->query) && !empty($request->query->all())){
                return $this->hotelRepository->getHotelsWithFilters($request->query->all());
            } else {
                return $this->hotelRepository->findBy('user_id', $request->user()->id);
            }
        });

        return $this->sendSuccess($hotels);
    }

    /**
     * @param  int  $id
     * @param  Request  $request
     * @return JsonResponse
     */
    public function show(int $id, Request $request): JsonResponse
    {
        $hotel = $this->hotelRepository->findHotelWithAuthentication($id, $request->user()->id);
        if ($hotel->isEmpty()){
            return $this->sendError('Unauthorized to see that item', 401);
        }

        return $this->sendSuccess($hotel);
    }

    /**
     * Create new entries
     *
     * @param  CreateHotelRequest  $request
     * @return JsonResponse
     */
    public function create(CreateHotelRequest $request): JsonResponse
    {
        $request->merge(['user_id' => $request->user()->id]);
        $hotel = $this->hotelRepository->store($request->all());

        return $this->sendSuccess($hotel);
    }

    /**
     * Update information of item
     *
     * @param  int  $id
     * @param  UpdateHotelRequest  $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateHotelRequest $request): JsonResponse
    {
        $hotel = $this->hotelRepository->update($id, $request->all());

        return $this->sendSuccess($hotel);
    }

    /**
     * Delete item
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $hotel = $this->hotelRepository->delete($id);

        return $this->sendSuccess($hotel, 204);
    }
}