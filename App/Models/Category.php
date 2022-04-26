<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;

class Category extends MysqlBaseModel
{
    protected $table = 'categories';

    public $property_category_tree_for_backend_by_type = [];
    public $property_category_tree_for_backend         = [];
    public $property_category_tree_for_frontend        = [];
    public $children                                   = [];

    public function category_tree_for_backend($parent_id = 0, $sub_mark = '', $type=0)
    {
        $get_categories = $this->get_all([
            'parent_id' => $parent_id,
            'type'      => $type,
        ]);
        if (is_array($get_categories)) {
            foreach ($get_categories as  $value) {
                array_push(
                    $this->property_category_tree_for_backend,
                    array(
                        'name'   => $sub_mark . $value['name'],
                        'id'     => $value['id'],
                        'parent' => $value['parent_id'],
                        'slug'   => $value['slug'],
                    )
                );
                $this->category_tree_for_backend($value['id'], $sub_mark . ' <b> &#10010; </b> ', $type);
            }
        }
        return $this->property_category_tree_for_backend;
    }

    public function get_categories_for_product_breadcrumb($id, $breadcrumb=[])
    {
        $get_categories = $this->get_all([
            'id'        => $id,
            'type'      => 0,
        ]);

        $breadcrumb[]=$get_categories;

        if($get_categories[0]['parent_id'] != 0){
            return $this->get_categories_for_product_breadcrumb($get_categories[0]['parent_id'], $breadcrumb);
        } else {
            return $breadcrumb;
        }
    }

    public function category_tree_for_frontend($parent_id = 0, $slug = NULL)
    {
        global $request;
        // $value = $this->left_join(
            // "categories.*,photos.path,photos.alt",
            // "photos",
            // "id",
            // "entity_id",
            // "categories.parent_id={$parent_id['id']}"
        // );
		
		$value=$this->query("SELECT * FROM `categories` as cat LEFT JOIN `photos` as photo
		ON photo.`entity_type` = 'Category' AND photo.`entity_id` = cat.`id`
		WHERE cat.`type` = 0 AND cat.`parent_id` = ".$parent_id['id']);
		
        return $value;
        if (!empty($value)) {
            array_push(
                $this->property_category_tree_for_frontend,
                array(
                    'name'        => $value[0]['name'],
                    'id'          => $value[0]['id'],
                    'parent'      => $value[0]['parent_id'],
                    'slug'        => $value[0]['slug'],
                    'path'        => $value[0]['path'],
                    'alt'         => $value[0]['alt'],
                    'description' => $value[0]['description'],
                )
            );
            // return       $this->property_category_tree_for_frontend;
        } else {

            return $request::redirect("product/category/$parent_id/$slug");
        }
    }


    public function create_category(array $params)
    {
        return $this->create($params);
    }
    public function create_categoryDiscount(array $params)
    {
        $this->connection->insert('category_discounts', $params);
        return  $this->connection->id();
    }
    public function replace_categoryDiscount(array $params, $id)
    {
        $this->connection->delete('category_discounts', ['discount_id' => $id]);
        return  $this->connection->insert('category_discounts', $params);
    }
    public function read_category($id = null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->first(['id' => $id]);
    }
    public function read_category_by_slug($slug = null)
    {
		$results=$this->query("SELECT * FROM `categories` WHERE `slug` = '$slug'");
        return $results[0];
    }
    public function read_category_by_type($type)
    {
        return $this->get('*', ['type' => $type]);
    }

    public function update_category(array $params, $id)
    {
        return $this->update($params, ['id' => $id]);
    }

    public function delete_category($id)
    {
        return $this->delete(['id' => $id]);
    }
    public function join_category_to_photo($id)
    {
        /* return $this->inner_join(
            "categories.id AS categories_id , categories.* , photos.*",
            "photos",                      // -- table photos
            "id",                          // categories.id
            "entity_id",                   // photos.entity_id
            "categories.id = $id",
            "photos.entity_type='Category'",

        ); */
		return $this->query("SELECT cats.*,img.`path`,img.`alt` FROM `categories` as cats LEFT JOIN `photos` as img ON cats.`id` = img.`entity_id` AND img.`entity_type` = 'Category' WHERE cats.`id` = '$id'");
    }
    public function join_category_to_product_categories($id)
    {
        $products = $this->inner_join(
            "product_categories.product_id",
            "product_categories",
            "id",
            "category_id",
            "categories.id=$id",
        );


        $productModel = new Product();
        foreach ($products as  $value) {
            $product[] = $productModel->join_product_to_photo_by_id($value['product_id'])[0];
        }

        return  $product??[];
    }
    public function left_join_category_to_photo($id)
    {
        return $this->left_join(
            "categories.id AS categories_id , categories.* , photos.*",
            "photos",                      // -- table photos
            "id",                          // categories.id
            "entity_id",                   // photos.entity_id
            "categories.id = $id",
            "photos.entity_type='Category'",

        );
    }
}
