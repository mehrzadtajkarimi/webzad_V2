<?php

namespace App\Models\Contracts;

use Medoo\Medoo;
use App\Services\Auth\Auth;

class  MysqlBaseModel extends BaseModel
{
    function __construct($id = null)
    {
        try {
            $this->connection = new Medoo([
                'type'      => 'mysql',
                'host'      => $_ENV['DB_HOST'],
                'database'  => $_ENV['DB_NAME'],
                'username'  => $_ENV['DB_USER'],
                'password'  => $_ENV['DB_PASS'],
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'port'      => 3306,
                'prefix'    => '',
                // [optional] Enable logging, it is disabled by default for better performance.
                'logging' => true,
                // PDO::ERRMODE_SILENT (default) | PDO::ERRMODE_WARNING | PDO::ERRMODE_EXCEPTION
                'error' => \PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (\PDOException $e) {
            echo '<h1>مشکلی در ارتباط با دیتابیس رخ داد </h1>';
        }

        if (!is_null($id)) {
            return $this->find($id);
        }
    }

    public function create(array $data)
    {
        try {
            $this->connection->insert($this->table, $data);
            return $this->connection->id();
        } catch (\PDOException $e) {
            echo 'مشکلی در هنگام ذخیره اطلاعات رخ داد/n';
            var_dump($e);
        }
    }

    public function find($id): object
    {
        // return  $this->connection->get($this->table, '*', [$this->primaryKey => $id]) ?? new \stdClass;
        $record = $this->connection->get($this->table, '*', [$this->primaryKey => $id]) ?? new \stdClass;
        foreach ($record as $key => $value) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }
    public function find_by_id($id)
    {
        return  $this->connection->get($this->table, '*', [$this->primaryKey => $id]);
    }

    public function count_by($field, $value)
    {
        return count($this->get($field, $value));
    }

    public function all(): array
    {
        return $this->get('*');
    }

    public function get_all($where = null, $columns = "*"): array
    {
        if ($where == null) {
            return $this->connection->select($this->table, $columns);
        } else {
            return $this->connection->select($this->table, $columns, $where);
        }
    }

    public function  get($columns = '*', array $where = null): array
    {
        $page    = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
        $start   = ($page - 1) * $this->pageSize;
        $where['LIMIT'] = [$start, $this->pageSize];

        $where["ORDER"] = ["id" => "DESC"];

        return $this->connection->select($this->table, $columns, $where);
    }
    public function  get_order_asc($columns = '*', array $where = null): array
    {
        $where["ORDER"] = ["id" => "ASC"];
        // end pagination

        return $this->connection->select($this->table, $columns, $where);
    }

    public function  first(array $where)
    {
        $first = $this->connection->select($this->table, '*', $where);
        return  $first[0] ?? [];
    }

    public function update(array $data, array $where): int
    {
        try {
            $result = $this->connection->update($this->table, $data, $where);
            return $result->rowCount();
        } catch (\PDOException $e) {
            echo '<h1>مشکلی در ارتباط با دیتابیس رخ داد </h1>';
            var_dump($e);
        }
    }

    public function update_create(array $data, array $where): int
    {
        try {
            $exists = $this->has($where);
            if (empty($exists)) {
                return  $this->create($data);
            }
            return $this->update($data, $where);
        } catch (\PDOException $e) {
            echo '<h1>مشکلی در ارتباط با دیتابیس رخ داد </h1>';
        }
    }
    public function update_delete(array $data, array $where): int
    {
        try {
            $exists = $this->get($where);
            foreach ($exists as  $value) {
                return  $this->delete($value['id']);
            }
            return $this->update($data, $where);
        } catch (\PDOException $e) {
            echo '<h1>مشکلی در ارتباط با دیتابیس رخ داد </h1>';
        }
    }

    public function delete(array $where): int
    {
        $result = $this->connection->delete($this->table,  $where);
        return $result->rowCount();
    }

    public function count(array $where =null): int
    {
        return $this->connection->count($this->table,  $where);
    }

    public function has(array $where): int
    {
        return $this->connection->has($this->table,  $where);
    }

    public function select($columns = '*', $where = null)
    {
        return $this->connection->select($this->table, $columns, $where);
    }
    public function query($query)
    {
        return $this->connection->query($query)->fetchAll();
    }





    public function inner_join(
        $column,
        $join,
        $columns_as,
        $columns_to,
        $where_1 = null,
        $where_2 = null,
        $where_3 = null,
        $where_4 = null
    ) {
        $query = "
        SELECT $column FROM $this->table
        INNER JOIN $join
        ON $this->table.$columns_as = $join.$columns_to
        ";
        if ($where_1) {
            return $this->connection->query("$query AND $where_1")->fetchAll();
        }
        if ($where_2) {
            return $this->connection->query("$query AND $where_1 AND $where_2")->fetchAll();
        }
        if ($where_3) {
            return $this->connection->query("$query AND $where_1 AND $where_2 AND $where_3")->fetchAll();
        }
        if ($where_4) {
            return $this->connection->query("$query AND $where_1 AND $where_2 AND $where_3 AND $where_4")->fetchAll();
        }
        return $this->connection->query("$query")->fetchAll();
    }


    public function inner_join_order(
        $column,
        $join,
        $columns_as,
        $columns_to,
        $where_1,
        $where_2,
        $order_by
    ) {
        return $this->connection->query("
        SELECT $column FROM $this->table
        INNER JOIN $join
        ON $this->table.$columns_as = $join.$columns_to
        AND $where_1
        AND $where_2
        ORDER BY $order_by DESC
        ")->fetchAll();
    }
    public function inner_join_limit(
        $column,
        $join,
        $columns_as,
        $columns_to,
        $where_1,
        $where_2,
        $limit_by
    ) {
        return $this->connection->query("
        SELECT $column FROM $this->table
        INNER JOIN $join
        ON $this->table.$columns_as = $join.$columns_to
        AND $where_1
        AND $where_2
        LIMIT $limit_by
        ")->fetchAll();
    }
    public function inner_join_sale(
        $column,
        $join,
        $columns_as,
        $columns_to,
        $where_1,
        $where_2,
        $where_3,
        $limit_by
    ) {
        return $this->connection->query("
        SELECT $column FROM $this->table
        INNER JOIN $join
        ON $this->table.$columns_as = $join.$columns_to
        AND $where_1
        AND $where_2
        AND $where_3
        LIMIT $limit_by
        ")->fetchAll();
    }
    public function inner_join_featured(
        $column,
        $join,
        $columns_as,
        $columns_to,
        $where_1,
        $where_2,
        $where_3,
        $limit_by
    ) {
        return $this->connection->query("
        SELECT $column FROM $this->table
        INNER JOIN $join
        ON $this->table.$columns_as = $join.$columns_to
        AND $where_1
        AND $where_2
        AND $where_3
        LIMIT $limit_by
        ")->fetchAll();
    }
    public function left_join(
        $column,
        $join,
        $columns_as,
        $columns_to,
        $where_1,
        $where_2 = null,
        $where_3 = null
    ) {
        $query = "
        SELECT $column FROM $this->table
        LEFT JOIN $join
        ON $this->table.$columns_as = $join.$columns_to
        ";
        if ($where_2) {
            die("$query WHERE $where_1 AND $where_2");
            return $this->connection->query("$query WHERE $where_1 AND $where_2")->fetchAll();
        }
        if ($where_3) {
            die('3: ' . $query);
            return $this->connection->query("$query WHERE $where_1 AND $where_2 AND $where_3")->fetchAll();
        }
        return $this->connection->query("$query WHERE $where_1")->fetchAll();
    }



    public function inner_join_two(
        $column,
        $join_one,
        $table_one_as,
        $table_one_to,
        $join_two,
        $table_two_as,
        $table_two_to,
        $where_1 = null,
        $where_2 = null,
        $where_3 = null,
        $where_4 = null
    ) {
        $query = "
        SELECT $column FROM $this->table
        INNER JOIN $join_one
        ON $this->table.$table_one_as = $join_one.$table_one_to
        INNER JOIN $join_two
        ON $this->table.$table_two_as = $join_two.$table_two_to
        ";
        if ($where_1) {
            return $this->connection->query("$query AND $where_1")->fetchAll();
        }
        if ($where_2) {
            return $this->connection->query("$query AND $where_1 AND $where_2")->fetchAll();
        }
        if ($where_3) {
            return $this->connection->query("$query AND $where_1 AND $where_2 AND $where_3")->fetchAll();
        }
        if ($where_4) {
            return $this->connection->query("$query AND $where_1 AND $where_2 AND $where_3 AND $where_4")->fetchAll();
        }
        return $this->connection->query("$query")->fetchAll();
    }

    public function inner_join_two_relation(
        $column,
        $join_one,
        $table_one_as,
        $table_one_to,
        $join_two,
        $table_two_as,
        $table_two_to,
        $where_1,
        $where_2 = null,
        $where_3 = null,
        $where_4 = null
    ) {
        $query = "
        SELECT $column FROM $this->table
        INNER JOIN $join_one
        ON $this->table.$table_one_as = $join_one.$table_one_to
        INNER JOIN $join_two
        ON $join_one.$table_two_as = $join_two.$table_two_to
        ";
        if ($where_2) {
            return $this->connection->query("$query AND $where_1 AND $where_2")->fetchAll();
        }
        if ($where_3) {
            return $this->connection->query("$query AND $where_1 AND $where_2 AND $where_3")->fetchAll();
        }
        if ($where_4) {
            return $this->connection->query("$query AND $where_1 AND $where_2 AND $where_3 AND $where_4")->fetchAll();
        }
        return $this->connection->query("$query AND $where_1")->fetchAll();
    }


    // SELECT product.id, product.name,
    // (SELECT group_concat(CONCAT('["',images.url, '",',  images.order_number,']')) FROM images WHERE images.product_id = product.id GROUP BY (product.id)) AS IMAGES_LIST,
    // (SELECT GROUP_CONCAT(CONCAT('["',prices.combination, '","', prices.currency, '",', prices.price,"]" )) FROM prices WHERE prices.product_id = product.id GROUP BY (product.id)) AS PRICE_LIST,
    // (SELECT GROUP_CONCAT(CONCAT('["',quantites.combination, '",',  quantites.quantity,"]")) FROM quantites WHERE quantites.product_id = product.id GROUP BY (product.id)) AS Quantity_LIST
    // FROM product WHERE product.id = 1


    public function inner_join_tree(
        $column,
        $join_table_one,
        $table_one_as,
        $table_one_to,
        $join_table_two,
        $table_two_as,
        $table_two_to,
        $join_table_tree,
        $table_tree_as,
        $table_tree_to,
        $where_1,
        $where_2 = null,
        $where_3 = null
    ) {
        $query = "
        SELECT $column FROM  $this->table
        INNER JOIN $join_table_one t1
        ON $this->table.$table_one_as = t1.$table_one_to
        INNER JOIN $join_table_two t2
        ON $this->table.$table_two_as = t2.$table_two_to
        INNER JOIN $join_table_tree t3
        ON $this->table.$table_tree_as = t3.$table_tree_to
        ";
        if ($where_2) {
            return $this->connection->query("$query AND $where_1 AND $where_2")->fetchAll();
        }
        if ($where_3) {
            return $this->connection->query("$query AND $where_1 AND $where_2 AND $where_3")->fetchAll();
        }
        return $this->connection->query("$query AND $where_1")->fetchAll();
    }

    public function activity_log(string $type, int $id = null, array $new_value = null)
    {

        if ($type == 'create') {
            $returnedID = $this->connection->id();
            $this->connection->insert("activity_log", [
                'user_id'         => Auth::is_login(),
                'ip'              => $_SERVER['REMOTE_ADDR'],
                'type'            => $type,
                'target_table'    => $this->table,
                'uri'             => $_SERVER['REQUEST_URI'],
            ]);
            return $returnedID;
        }
        if ($type == 'read') {
            if ($id != null) {
                $this->connection->insert("activity_log", [
                    'user_id'         => Auth::is_login(),
                    'ip'              => $_SERVER['REMOTE_ADDR'],
                    'type'            => $type,
                    'target_table'    => $this->table,
                    'row_id'          => $id,
                    'uri'             => $_SERVER['REQUEST_URI'],
                ]);
            } else {
                die("id is null");
            }
            return true;
        }
        if ($type == 'update') {
            if ($id != null && $new_value != null) {
                $oldData = $this->connection->select($this->table, '*', $id);
                $this->connection->insert("activity_log", [
                    'user_id'         => Auth::is_login(),
                    'ip'              => $_SERVER['REMOTE_ADDR'],
                    'type'            => $type,
                    'target_table'    => $this->table,
                    'row_id'          => $oldData['id'],
                    'detailed_data'   => json_encode(["old" => $oldData, "new" => $new_value]),
                    'uri'             => $_SERVER['REQUEST_URI'],
                ]);
            } else {
                die("id or new_value is null");
            }
            return true;
        }
        if ($type == 'delete') {
            if ($id != null) {
                $oldData = $this->connection->select($this->table, '*', $id);
                $returnedID = $this->connection->id();
                $this->connection->insert("activity_log", [
                    'user_id'         => Auth::is_login(),
                    'ip'              => $_SERVER['REMOTE_ADDR'],
                    'type'            => $type,
                    'target_table'    => $this->table,
                    'row_id'          => $oldData['id'],
                    'detailed_data'   => json_encode(["old" => $oldData]),
                    'uri'             => $_SERVER['REQUEST_URI'],
                ]);
            } else {
                die("id is null");
            }
            return  $returnedID;
        }

        die('  خطا در قسمت لاگ گیری :‌ مقادیر پارامتر اول ورودی صحیح نمی باشد باید یکی از { create , read , update , delete} باشد ');
    }
}
