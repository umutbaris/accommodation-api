<?php
namespace App\Repositories;
use App\User;

class UserRepository extends BaseRepository {

    /**
     * @var User
     */
    protected $modelName = User::class;
}
