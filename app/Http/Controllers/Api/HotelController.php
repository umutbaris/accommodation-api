<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\CreateHotelRequest;
use App\Repositories\HotelRepository;

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
     * Get all the items for the given hotelier
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $hotels = $this->hotelRepository->all();
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
        $hotel = $this->hotelRepository->store($request->all());
        return $this->sendSuccess($hotel, 201);
    }

    /**
     * Update information of item
     *
     * @param  int  $id
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
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