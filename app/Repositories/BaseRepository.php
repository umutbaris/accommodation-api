<?php

namespace App\Repositories;


class BaseRepository {

    /**
     * @var
     */
    protected $modelName;

    public function all(array $relations = [])
    {
        $instance = $this->getNewInstance();
        return $instance->with($relations)->get();
    }

    public function find(int $id, array $relations = [])
    {
        $instance = $this->getNewInstance();
        return $instance->with($relations)->find($id);
    }

    public function store(array $data)
    {
        $instance = $this->getNewInstance();
        $instance->fill($data);
        $instance->save();
        return $instance;
    }

    public function update(int $id, array $data)
    {
        $instance = $this->find($id);
        if ($instance === null) {
            return null;
        }
        $instance->fill($data);
        $instance->save();
        return $instance;
    }

    public function delete(int $id)
    {
        $instance = $this->find($id);
        if ($instance === null) {
            return null;
        }
        $instance->delete();
        return $instance;
    }

    public function findBy(string $field, string $value, array $relations = [])
    {
        $instance = $this->getNewInstance();
        return $instance->where($field, $value)->with($relations)->get();
    }

    public function getNewInstance()
    {
        $model = $this->modelName;
        return new $model;
    }
}