<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;

class Product_category extends MysqlBaseModel
{
    protected $table = 'product_categories';

    public function create_productCategories($params)
    {
        return $this->create($params);
    }
    public function replace_productCategories(array $params, $id)
    {
        $discount_id = ['discount_id' => $id];
        if (!empty($this->get('*', $discount_id))) {
            $this->delete($discount_id);
        }
        return  $this->create($params);
    }

    public function read_productCategories($product_id = null)
    {
        $categories =  $this->inner_join(
            '*',
            'categories',
            'category_id',
            'id',
            "product_categories.product_id={$product_id}",
        );
        return $categories;
    }

    public function read_products_by_category_id($category_id = null)
    {
        $products =  $this->inner_join(
            '*',
            'products',
            'product_id',
            'id',
            "product_categories.category_id={$category_id}",
        );
        return $products;
    }



    public function update_productCategories($category_id, $product_id)
    {
        $this->delete(['product_id' => $product_id]);
        return $this->update_delete(
            [
                'category_id' => $category_id,
                'product_id' => $product_id
            ],
            ['product_id' => $category_id]
        );
    }

    public function read_productCategories_by_product_id(int $product_id)
    {
        return $this->has(['product_id' => $product_id]);
    }
    public function delete_productCategories_by_product_id(int $product_id)
    {
        return   $this->delete(['product_id' => $product_id]);

    }
}
