<?php


namespace App\Repositories;

use App\Hotel;

class HotelRepository extends BaseRepository
{
    protected $modelName = Hotel::class;

    /**
     * @param  array  $data
     * @return mixed
     */
    public function store($data) {
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
    public function update($id, $data) {
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

        return $hotel;
    }

    /**
     * @param $id
     * @param $userId
     * @return mixed
     */
    public function findHotelWithAuthentication($id, $userId) {
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
    public function calculateReputationBadge(int $reputation) {
        $reputationBadge = 'green';
        if($reputation <= 799) {
            $reputationBadge = 'yellow';
        }

        if($reputation <= 500) {
            $reputationBadge = 'red';
        }

        return $reputationBadge;
    }
}