<?php


namespace App\Repositories;

use App\Hotel;

class HotelRepository extends BaseRepository
{
    protected $modelName = Hotel::class;

    /**
     * HotelRepository constructor.
     * @param  CategoryRepository  $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param  array  $data
     * @return mixed
     */
    public function store($data)
    {
        try {
            $data['reputation_badge'] = $this->calculateReputationBadge($data['reputation']);
            $hotel = parent::store($data);
            $hotel->location()->create($data['location']);
        } catch (Exception $e) {
            return $e;
        }

        return $hotel;
    }

    /**
     * @param  array  $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $instance = $this->find($id);
        if ($instance === null) {
            return null;
        }
        if (isset($data['reputation'])) {
            $data['reputation_badge'] = $this->calculateReputationBadge($data['reputation']);
        }

        $instance->fill($data);
        $instance->save();

        return $instance;
    }

    /**
     * @param $id
     * @param $userId
     * @return mixed
     */
    public function findHotelWithAuthentication($id, $userId)
    {
        $instance = $this->getNewInstance();
        return $instance->where(['id'=>$id, 'user_id'=>$userId])->get();
    }

    /**
     * The reputation badge is a calculated value that depends on the reputation
     *
     * @todo Calculation part can change using like map according to range to make generic
     * 
     * @param  Integer  $reputation
     * @return string
     */
    public function calculateReputationBadge(int $reputation)
    {
        $reputationBadge = 'green';
        if($reputation <= 799) {
            $reputationBadge = 'yellow';
        }

        if($reputation <= 500) {
            $reputationBadge = 'red';
        }

        return $reputationBadge;
    }

    /**
     * Hotels Fetching From Db According To Parameters Filters
     *
     * @param  array  $parameters
     * @return mixed
     */
    public function getHotelsWithFilters(array $parameters)
    {
        $parameters = $this->sanitizeParameters($parameters);
        if(array_key_exists('category', $parameters)){
            $parameters = $this->replaceCategoryKey($parameters);
        }

        $instance = $this->getNewInstance();
        if(array_key_exists('max-availability', $parameters)) {
                $query = $instance->where('availability', '<', $parameters['max-availability']);
                unset($parameters['max-availability']);
        }

        if(array_key_exists('min-availability', $parameters)) {
            $query = $instance->where('availability', '>', $parameters['min-availability']);
            unset($parameters['min-availability']);
        }


        if(array_key_exists('city', $parameters)){
            $query = $this->filterByCity($parameters, $query);
        } else {
            $query->where($parameters);
        }

        return $query->get();
    }

    /**
     * Sanitize parameters permit only valid query params
     *
     * @param  array  $parameters
     * @return array
     */
    public function sanitizeParameters(array $parameters)
    {
        $validFilters = explode(',', env('FILTERS'));
        foreach ($parameters as $key => $parameter) {
            if(!in_array($key, $validFilters)){
                unset($parameters[$key]);
            }
        }

        return $parameters;
    }

    /**
     * Need to use hotel id into slug
     *
     * @param  array  $parameters
     * @return array
     */
    public function replaceCategoryKey(array $parameters)
    {
        $categoryId = $this->categoryRepository->getCategoryIdFromSlug($parameters['category']);
        if($categoryId){
            $parameters['category_id'] = $categoryId;
        }
        unset($parameters['category']);

        return $parameters;
    }

    /**
     * Filtering hotels result according to city
     *
     * @param  array  $parameters
     * @param $query
     * @return mixed
     */
    public function filterByCity(array $parameters, $query)
    {
        $city = $parameters['city'];
        unset($parameters['city']);
        $qb = $query->where($parameters);

        return  $qb->whereHas('location', function($query) use($city) {
            $query->where('city', $city);
        });
    }
}