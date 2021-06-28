<?php


namespace App\Repositories;


use App\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * @var Category
     */
    protected $modelName = Category::class;

    /**
     * @param $slug
     * @return int
     */
    public function getCategoryIdFromSlug($slug): int
    {
        $instance = $this->getNewInstance();
        $categoryId = null;
        if(!$instance->where(['slug'=>$slug])->get()->isEmpty()){
            $categoryId = $instance->where(['slug'=>$slug])->get()->first()->id;
        }

        return $categoryId;
    }
}