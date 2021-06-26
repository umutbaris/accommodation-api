<?php


namespace App\Repositories;


use App\Category;

class CategoryRepository extends BaseRepository
{
    protected $modelName = Category::class;


    /**
     * @param $slug
     * @return array
     */
    public function getCategoryIdFromSlug($slug)
    {
        $instance = $this->getNewInstance();
        $categoryId = null;
        if(!$instance->where(['slug'=>$slug])->get()->isEmpty()){
            $categoryId = $instance->where(['slug'=>$slug])->get()->first()->id;
        }

        return $categoryId;
    }
}