<?php

use App\Core\Request;
use App\Models\Category;
use App\Models\User;
use App\Services\Auth\Auth;
use App\Services\Basket\Basket;
use App\Services\Session\SessionManager;
use Medoo\Medoo;

function base_url($route = null)
{
    return  $_ENV['BASE_URL'] . $route;
}
function base_url_admin($route = null)
{
    return  $_ENV['BASE_URL'] . 'admin/' . $route;
}
function asset_url_front($route = null)
{
    return  base_url('Public/Assets/Frontend/' . $route);
}
function asset_url_back($route = null)
{
    return  base_url('Public/Assets/Backend' . $route);
}
function view($path, $data = [], $layout = null)
{
    $path = str_replace('.', '/', $path);
    $path_explode = explode('/', $path);
    $full_path = BASEPATH . "App/Views/$path.php";
    $is_file = is_readable($full_path) && file_exists($full_path);
    if ($path_explode[0] == 'Frontend') {
        $data += inject_menu();
    }
    if (SessionManager::has('onLoadMsg')) {
        $data['onLoadMsg'] = SessionManager::get('onLoadMsg');
        SessionManager::remove('onLoadMsg');
    }
    if (is_null($layout)) {
        $is_file ? buffering($full_path, $data, $path_explode[0]) : include_once BASEPATH . "App/Views/Error/404.php";
    }
    $is_file ? buffering($full_path, $data) : include_once BASEPATH . "App/Views/Error/404.php";
}
function inject_menu()
{
    $cart_items = Basket::items();
    unset($cart_items['percent']);
    $cart_count = count($cart_items);

    foreach ($cart_items as  $value) {
        $cart_total[] = $value['count'] * $value['price'] ?? [];
    }
    $categoryModel = new Category;
    $categoryLevelOne = $categoryModel->get_all([
        'parent_id' => 0,
        'type'      => 0,
    ]);
    foreach ($categoryLevelOne as $LevelOne) {
        $level_two = $categoryModel->get_all([
            'parent_id' => $LevelOne['id'],
            'type'      => 0,
        ], 'id');
        $firstLevelTwoItem = $categoryModel->join_category_to_photo($LevelOne['id']);
        $categoryLevelTwo[$LevelOne['id']] = [$firstLevelTwoItem[0]];
        foreach ($level_two as $level_two_id) {
            $categories_level_two = $categoryModel->get_all(['id' => $level_two_id]);
            foreach ($categories_level_two as $key => $category_level_two) {
                $categories_level_two_add_photo = $categoryModel->join_category_to_photo($category_level_two['id']);
                if (count($categories_level_two_add_photo) > 0)
                    array_push($categoryLevelTwo[$LevelOne['id']], $categories_level_two_add_photo[$key]);
            }
        }
    }

    if ($categoryLevelOne) {
        return  [
            'categoryLevelOne' => $categoryLevelOne,
            'categoryLevelTwo' => $categoryLevelTwo,
            'cart_total'       => array_sum($cart_total ?? []),
            'cart_count'       => $cart_count,
            'cart_items'       => $cart_items ?? [],
            'authenticated'    => Auth::is_login(),
        ];
    }
    return [];
}
function inject_about_menu()
{
    return;
}
function create_slug($string)
{
    // $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    $slug = str_replace([
        "+",
        "(",
        ")",
        ".",
        ",",
        ";",
        "/",
        "&",
        " ",
        "'",
        '"',
        "،",
        "؛",
        "\r\n",
        "\n",
        "!",
        "?",
        "؟",
        "«",
        "»",
        ":"
    ], [
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "-",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        ""
    ], strip_tags($string));
    return $slug;
}
function buffering($full_path_view, $data, $dir = null)
{
    if (!is_null($dir)) {
        ob_start();
        extract($data);
        include_once $full_path_view;
        $view = ob_get_clean();
        include_once BASEPATH . "App/Views/$dir/layouts/master.php";
    }
    include_once $full_path_view;
}

function view_flash_message($path, $data = [])
{
    $path = str_replace('.', '/', $path);
    ob_start();
    extract($data);
    include_once BASEPATH . 'App/Views/' . $path . '.php';
    echo  ob_get_clean();
}

function xss_clean($str)
{
    return filter_var(htmlspecialchars($str));
}

function dd(...$categoryLevelTwo)
{
    echo '<pre style="background:#FF5722; border-radius: 10px; padding: 20PX">';
    var_dump($categoryLevelTwo);
    die();
}

function include_data($full_path_view, $data)
{

    ob_start();
    extract($data);
    include_once $full_path_view;
    echo  ob_get_clean();
}

function contains_array($array)
{
    foreach ($array as $value) {
        if (is_array($value)) {
            return true;
        }
    }
    return false;
}

function storage_url($filename)
{
    return base_url() . "Storage/$filename";
}

function storage_path($filename)
{
    return base_url() . $filename;
}



function is_active($routeName, $activeClassName = 'active menu-open d-block')
{
    $request = new  Request();
    $preg_replace = preg_replace('~\d+/~', '', $request->uri(), 1);
    if (is_array($routeName)) {
        return in_array($preg_replace, $routeName) ? $activeClassName : '';
    }
    return $preg_replace == $routeName ? $activeClassName : '';
}

function admin_name($name)
{
    $admin_id = Auth::is_login();
    $userModel = new User();
    return $userModel->get_admin($admin_id)[$name];
}
function can(string $name)
{
    // $admin_id = Auth::is_login();

    // $permissionModel = new Permission_user();
    // $roleUserModel   = new Role_user();

    // $has_permission = $permissionModel->has_permission($admin_id);
    // $has_role       = $roleUserModel->has_role($admin_id);

    // if ($has_role) {
    //     $join_roleUser_roles = $roleUserModel->join_roleUser_role($admin_id);
    //     $rolePermissionModel = new Role_permission();
    //     foreach ($join_roleUser_roles as  $value) {
    //         if ($value['name'] == $name || $value['name'] == 'super-admin' || ($value['name'] == 'super-user' && $name != "super-admin")) {
    //             return TRUE;
    //         }
    //         $has_permission = $rolePermissionModel->get_permissions($value['id']);
    //         if ($has_permission == $name) {
    //             return TRUE;
    //         }
    //     }
    // }

    // if ($has_permission) {
    //     $has_permissions = $permissionModel->join_permissionUser_permission($admin_id);
    //     foreach ($has_permissions as  $value) {
    //         if ($value['name'] == $name) {
    //             return TRUE;
    //         }
    //     }
    // }
    // return FALSE;
}
function search_categories()
{
    $categoryModel = new Category();
    return $categoryModel->get('*', ['type' => 0]);
}


function pagination_count($table, $count, $where = null)
{
    // $MysqlBaseModel = new MysqlBaseModel();
    $query = connection()->count($table, $where);
    return floor($query / $count);
}

function pagination_total_count($count, $key)
{
    $page = $_GET['page'] ?? 1;
    return (($page - 1) * $count) + $key;
}

function connection()
{
    try {
        return new Medoo([
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
}
function level_user(): array
{
    return  [
        '1' => '* (برنزی)',
        '2' => '** (نقره ای)',
        '3' => '*** (طلایی)',
        '4' => '**** (پلاتین)',
        '5' => '***** (تیتانیوم)',
    ];
}
function status_sender(): array
{
    return  [
        0 => 'none',
        1 => 'post',
        2 => 'postbar',
        3 => 'chapar',
        4 => 'alopeyk',
        5 => 'snappـbox'
    ];
}

function jalaliDate($sqlTimestamp, $format = 'j F Y')
{
    $unixTimestamp = strtotime($sqlTimestamp);
    return jdate($format, $unixTimestamp);
}

function numRows($queryStr)
{
    $CON = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
    mysqli_query($CON, "SET NAMES utf8");
    mysqli_query($CON, "SET CHARACTER_SET utf8");
    $numRowsQuery = mysqli_query($CON, $queryStr);
    return mysqli_num_rows($numRowsQuery);
}

function replaceAll($str, $reverse = false)
{
    $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $east_arabic = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
    if (!$reverse) return str_replace($standard, $east_arabic, $str);
    else return str_replace($east_arabic, $standard, $str);
}

function generate_random_string($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
