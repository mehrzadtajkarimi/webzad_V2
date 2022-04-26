<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;

class Blog extends MysqlBaseModel
{
    protected $table = 'blogs';

    public function create_blog(array $params)
    {
        return $this->create($params);
    }
    public function read_blog($id = null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->find_by_id($id);
    }
    public function read_comment_replies($id = null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->find_by_id($id);
    }
    public function join_blog_to_photo_by_limit($limit)
    {
        return $this->connection->query("
        SELECT blogs.id AS blog_id , blogs.* , photos.* FROM blogs
        INNER JOIN photos
        ON blogs.id = photos.entity_id
		AND photos.`entity_type` = 'Blog'
        LIMIT $limit
        ")->fetchAll();
    }
    public function read_blog_by_slug($slug = null)
    {
        if (is_null($slug)) {
            return $this->all();
        }
        return $this->get('*', ['slug' => $slug]);
    }

    public function update_blog(array $params, $id)
    {
        return $this->update($params, ['id' => $id]);
    }

    public function delete_blog($id)
    {
        return $this->delete(['id' => $id]);
    }
    public function join_blog_to_photo()
    {
        // return $this->inner_join(
            // "blogs.id AS blog_id , blogs.* , photos.*",
            // "photos",
            // "id",
            // "entity_id",
            // "photos.entity_type='Blog'",
        // );
		return $this->query("SELECT bl.*,ph.`path`,ph.`alt` FROM `blogs` as bl INNER JOIN `photos` as ph
			ON bl.`id` = ph.`entity_id` AND ph.`entity_type` = 'Blog' GROUP BY bl.`id` ORDER BY bl.`id` DESC");
    }

    public function join_blog__with_comment($blog_id)
    {
        return $this->inner_join(
            "
            comments.*,
            blogs.id AS blog_id
            ", // column
            "comments",
            "id",
            "entity_id",
            "comments.status='1'",
            "comments.entity_id=$blog_id",
            "comments.entity_type='Blog'",
        );
    }

    public function join_blog__with_comment_replies($id)
    {
        return $this->inner_join(
            "*", // column
            "comment_replies",                // -- table categories
            "id",                        // categories.id
            "entity_id",               // products.category_id
            "comments.status='1'",
            "comments.parent_id=$id",
            "comments.entity_type='Blog'",
        );
    }
    public function join_blog_to_photo_by_blog_id($blog_id = null)
    {
        return $this->inner_join(
            "blogs.id AS blog_id , blogs.* , photos.*",
            "photos",
            "id",
            "entity_id",
            "blogs.id=$blog_id",
            "photos.entity_type='Blog'",
        );
    }
    public function join_blog_to_photo_and_category_blog($category_id = null)
    {
        return $this->inner_join_two(
            "blogs.id AS blog_id ,
            category_blogs.category_id AS category_blog_id ,
            blogs.* ,
            photos.*",
            "photos",
            "id",
            "entity_id",
            "category_blogs",
            "id",
            "blog_id",
            "category_blogs.category_id={$category_id['id']}",
            "photos.entity_type='Blog'",
        );
    }
}
