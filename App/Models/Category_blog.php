<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;

class Category_blog extends MysqlBaseModel
{
    protected $table = 'category_blogs';

    public function delete_categoryDiscount_by_category_id($category_id)
    {
        return   $this->delete(['category_id' => $category_id]);
    }
    public function delete_blogCategories_by_blog_id($blog_id)
    {
        return   $this->delete(['blog_id' => $blog_id]);
    }
    public function create_blogCategories($params)
    {
        $this->create($params);
    }

    public function read_categoryBlog($id = null)
    {
        $category_id =  $this->get('category_id', ['blog_id' => $id]) ?? '';
        return $category_id ? $this->connection->select('categories', ['id'], ['id' => $category_id]) : false;
    }
}
