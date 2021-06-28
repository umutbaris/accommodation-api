<?php


namespace App\Repositories;

use App\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;

class HotelRepository extends BaseRepository
{
    /**
     * @var Hotel
     */
    protected $modelName = Hotel::class;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

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
    public function store(array $data): Hotel
    {
        try {
            $data['reputation_badge'] = $this->calculateReputationBadge($data['reputation']);
            $hotel = parent::store($data);
            $hotel->location()->create($data['location']);
        } catch (\Throwable $e) {
            return $e;
        }
        Artisan::call('cache:clear');

        return $hotel;
    }


    /**
     * @param  int  $id
     * @param  array  $data
     * @return mixed|null
     */
    public function update(int $id, array $data): Hotel
    {
        if (isset($data['reputation'])) {
            $data['reputation_badge'] = $this->calculateReputationBadge($data['reputation']);
        }

        $instance = parent::update($id, $data);
        Artisan::call('cache:clear');

        return $instance;
    }

    /**
     * Need To Cache Clear
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $deleted = parent::delete($id);
        Artisan::call('cache:clear');

        return $deleted;
    }

    /**
     * @param $id
     * @param $userId
     * @return mixed
     */
    public function findHotelWithAuthentication(int $id, int $userId): Collection
    {
        $instance = $this->getNewInstance();
        return $instance->where(['id'=>$id, 'user_id'=>$userId])->get();
    }


    /**
     * The reputation badge is a calculated value that depends on the reputation
     *
     * @todo Calculation part can change using like map according to range to make generic
     *
     * @param  int  $reputation
     * @return string
     */
    public function calculateReputationBadge(int $reputation): string
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
    public function getHotelsWithFilters(array $parameters): Collection
    {
        $parameters = $this->sanitizeParameters($parameters);
        if(array_key_exists('category', $parameters)){
            $parameters['category_id'] = $this->categoryRepository->getCategoryIdFromSlug($parameters['category']);
            unset($parameters['category']);
        }

        $instance = $this->getNewInstance();
        $query= $instance->whereNotNull('id');
        if(array_key_exists('max-availability', $parameters)) {
                $query->where('availability', '<', $parameters['max-availability']);
                unset($parameters['max-availability']);
        }

        if(array_key_exists('min-availability', $parameters)) {
            $query->where('availability', '>', $parameters['min-availability']);
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
    public function sanitizeParameters(array $parameters): array
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