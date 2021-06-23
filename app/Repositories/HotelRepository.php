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
        $data['reputationBadge'] = $this->calculateReputationBadge($data['reputation']);
        $hotel = parent::store($data);

        return $hotel;
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