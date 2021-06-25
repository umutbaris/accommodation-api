<?php


namespace App\Http\Controllers\Api;


use App\Hotel;
use App\Http\Requests\CreateHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Repositories\HotelRepository;
use Illuminate\Http\Request;

class HotelController extends BaseApiController
{
    /**
     * @var HotelRepository
     */
    protected $hotelRepository;

    /**
     * HotelController constructor.
     * @param  HotelRepository  $hotelRepository
     */
    public function __construct(HotelRepository $hotelRepository)
    {
        $this->hotelRepository = $hotelRepository;
    }

    /**
     *
     * Get all the items for the given hotelier
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $hotels = $this->hotelRepository->findBy('user_id', $request->user()->id);
        return $this->sendSuccess($hotels);
    }

    /**
     * Get a single item
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $hotel = $this->hotelRepository->find($id);
        return $this->sendSuccess($hotel);
    }

    /**
     * Create new entries
     *
     * @param  CreateHotelRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateHotelRequest $request)
    {
        $request->merge(['user_id' => $request->user()->id]);
        $hotel = $this->hotelRepository->store($request->all());
        return $this->sendSuccess($hotel, 201);
    }

    /**
     * Update information of item
     *
     * @param  int  $id
     * @param  UpdateHotelRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, UpdateHotelRequest $request)
    {
        $hotel = $this->hotelRepository->update($id, $request->all());
        return $this->sendSuccess($hotel);
    }

    /**
     * Delete item
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $hotel = $this->hotelRepository->delete($id);
        return $this->sendSuccess($hotel, 204);
    }
}