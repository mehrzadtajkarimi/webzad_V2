<?php

namespace App\Controllers\Backend;

use App\Models\Order;
use App\Models\Order_Item;
use App\Services\Auth\Auth;
use App\Controllers\Controller;
use App\Models\Product;
use App\Models\See_log;
use App\Models\User;
use App\Models\Wish_list;
use App\Services\Session\SessionManager;
use App\Utilities\FlashMessage;

class HomeController extends Controller
{

    private $orderModel;
    private $orderItemModel;
    private $seeLogModel;
    private $userModel;
    private $wishModel;
    private $productModel;
    private $limits_chart_pir = 3;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel     = new Order();
        $this->orderItemModel = new Order_Item();
        $this->seeLogModel    = new See_log();
        $this->userModel      = new User();
        $this->wishModel      = new Wish_list();
        $this->productModel   = new Product();
        $this->limits_chart_pir = SessionManager::has('limits_chart_pir') ? SessionManager::get('limits_chart_pir') : 3;
    }


    public function index()
    {
        $param_quantity = $this->request->get_param('quantity');

        // dd($this->userModel->join_user_to_photo_all());

        // dd($this->calculations_mount_see_logs(true));

        if ($param_quantity != null) {
            SessionManager::remove('quantity_chart_pir');
            if ($param_quantity == 'grand_total') {
                SessionManager::set('quantity_chart_pir', 'grand_total');
            }
            if ($param_quantity == 'quantity_total') {
                SessionManager::set('quantity_chart_pir', 'quantity_total');
            }
        } else {
            $param_quantity = SessionManager::has('quantity_chart_pir') ? SessionManager::get('quantity_chart_pir') : 'grand_total';
        }

        $chart_pir             = $this->orderItemModel->join__orderItem_whit_product_sort($this->between_dates('this', 'year'), $this->limits_chart_pir, $param_quantity);
        $chart_pir_total_year  = $this->orderItemModel->read_order_item_between($this->between_dates('this', 'year'), $param_quantity);
        if ($param_quantity == 'grand_total') {
            foreach ($chart_pir as $key => $value) {
                $chart_pir[$key]['comparison'] = '%' . round((($value['grand_total'] - $chart_pir_total_year) / $chart_pir_total_year * 100) + 100);
            }
        }
        if ($param_quantity == 'quantity_total') {
            foreach ($chart_pir as $key => $value) {
                $chart_pir[$key]['comparison'] = '%' . round((($value['quantity_total'] - $chart_pir_total_year) / $chart_pir_total_year * 100) + 100);
            }
        }

        $this_day   = (int) $this->orderModel->comparison($this->between_dates('this', 'day'));
        $this_week  = (int) $this->orderModel->comparison($this->between_dates('this', 'week'));
        $this_month = (int) $this->orderModel->comparison($this->between_dates('this', 'month'));
        $this_year  = (int) $this->orderModel->comparison($this->between_dates('this', 'year'));
        $last_day   = (int) $this->orderModel->comparison($this->between_dates('last', 'day'));
        $last_week  = (int) $this->orderModel->comparison($this->between_dates('last', 'week'));
        $last_month = (int) $this->orderModel->comparison($this->between_dates('last', 'month'));
        $last_year  = (int) $this->orderModel->comparison($this->between_dates('last', 'year'));

        $limits_chart_pir = [];
        for ($i = 2; $i <= 10; $i++) {
            $limits_chart_pir[$i] = $i == $this->limits_chart_pir ? 'active' : '';
        }


        $data = array(

            'grand'    => $this->calculations_mount('grand'),
            'discount' => $this->calculations_mount('discount'),

            'orders_counts' => $this->orderModel->count(['status_sender[!]'=>0]),
            'user_counts'   => $this->userModel->count(),
            'which_counts'  => $this->wishModel->count(),

            'list_new_user' => $this->userModel->join_user_to_photo_all(),
            'list_new_product' => $this->productModel->join_product_to_photo_for_list_new(),

            'chart_pir'       => $chart_pir,
            'chart_pir_color' => ['danger', 'success', 'warning', 'primary', 'secondary', 'info', 'dark'],

            'chart_pir_this_as' => jdate('j F Y'),
            'chart_pir_this_to' => jdate('j F Y', strtotime("-1 year")),
            'chart_pir_last_as' => jdate('j F Y', strtotime("-1 year")),
            'chart_pir_last_to' => jdate('j F Y', strtotime("-2 year")),

            'count_see_logs_login_user'  => $this->calculations_mount_see_logs(true),         // count all see_log
            'count_see_logs_guest_user'  => $this->calculations_mount_see_logs(),         // count all see_log

            'count_order'  => $this->orderModel->count_order(),         // count all order
            'max_total'    => $this->orderModel->read_max_total(),      // max total of all orders
            'min_total'    => $this->orderModel->read_min_total(),      // min total of all orders
            'max_discount' => $this->orderModel->read_max_discount(),   // max discount of all orders

            'change_sale_year'  => $this_year && $last_year ? $this->percentage_change($this_year, $last_year) : 0,       // percentage change of sale year
            'change_sale_mount' => $this_month && $last_month ? $this->percentage_change($this_month, $last_month) : 0,    // percentage change of sale month
            'change_sale_week'  => $this_week && $last_week ? $this->percentage_change($this_week, $last_week) : 0,       // percentage change of sale week
            'change_sale_day'   => $this_day && $last_day ? $this->percentage_change($this_day, $last_day) : 0,         // percentage change of sale day

            'change_item_sale_year'  => $this->product_change_percentage('year', $param_quantity),
            'change_item_sale_month' => $this->product_change_percentage('month', $param_quantity),
            'change_item_sale_week'  => $this->product_change_percentage('week', $param_quantity),
            'change_item_sale_day'   => $this->product_change_percentage('day', $param_quantity),


            'limits_chart_pir'   => $limits_chart_pir,
            'quantity_chart_pir' => $param_quantity,

            'avg_grand'    => $this->orderModel->read_avg_grand(),      // avg grand total of all orders
            'avg_discount' => $this->orderModel->read_avg_discount(),   // avg discount of all orders

        );

        return view('Backend.index', $data);
    }

    public function product_change_percentage($when = 'year', $quantity = 'grand_total')
    {
        $cent = [];
        $this_items = $this->orderItemModel->join__orderItem_whit_product_sort($this->between_dates('this', $when), $this->limits_chart_pir, $quantity) ?? false;
        $last_items = $this->orderItemModel->join__orderItem_whit_product_sort($this->between_dates('last', $when), $this->limits_chart_pir, $quantity) ?? false;


        $this_items_name = array_column($this_items, 'product_name', 'product_id');
        $this_items_slug = array_column($this_items, 'product_slug', 'product_id');

        if ($quantity == 'grand_total') {
            $this_items_column = array_column($this_items, 'grand_total', 'product_id');
            $last_items_column = array_column($last_items, 'grand_total', 'product_id');
            foreach ($this_items_column as $key => $value) {
                if (in_array($key, array_keys($last_items_column))) {
                    $cent[$key] = [round(($value - $last_items_column[$key]) / $last_items_column[$key] * 100), $this_items_name[$key], $this_items_slug[$key]];
                } else {
                    $cent[$key] = 0;
                }
            }
        }
        if ($quantity == 'quantity_total') {
            $this_items_column = array_column($this_items, 'quantity_total', 'product_id');
            $last_items_column = array_column($last_items, 'quantity_total', 'product_id');
            foreach ($this_items_column as $key => $value) {
                if (in_array($key, array_keys($last_items_column))) {
                    $cent[$key] = [round(($value - $last_items_column[$key]) / $last_items_column[$key] * 100), $this_items_name[$key], $this_items_slug[$key]];
                } else {
                    $cent[$key] = 0;
                }
            }
        }

        return $cent;
    }

    public function sales_report()
    {
        $params = $this->request->params();

        $as = date('Y-m-d H:i:s', $params['start_at']);
        $to = date('Y-m-d H:i:s', $params['finish_at']);

        $msg_as = jdate('l , j F Y ', $params['start_at']);
        $msg_to = jdate('l , j F Y ', $params['finish_at']);

        // dd($params['order-type']);

        if ($params['order-type'] == 'all') {
            $order = $this->orderModel->get_orders($as, $to, 'all');
        } else if ($params['order-type'] == 'discount_total') {
            $order = $this->orderModel->get_orders($as, $to, 'discount_total');
        } else if ($params['order-type'] == 'grand_total') {
            $order = $this->orderModel->get_orders($as, $to, 'grand_total');
        } else {
            FlashMessage::add("مورد مورد نظر یافت نشد", FlashMessage::WARNING);
            return $this->request->redirect('admin/dashboard');
        }

        if (empty($order)) {
            FlashMessage::add("از (($msg_as)) تا (($msg_to)) این تاریخ فروشی صورت نگرفته", FlashMessage::ERROR);
            return $this->request->redirect('admin/dashboard');
        }

        $data = [
            'title'  => 'گزارش فروش',
            'type'   => 'line',
            'report' => $order,
            'as'     => $params['start_at'],
            'to'     => $params['finish_at'],
            'user'   => Auth::user(),
        ];

        return view('Backend.report.index', $data);
    }

    public function between_dates($When, $topic)
    {
        if ($When === 'this') {
            return  [
                'as' => date('Y-m-d H:i:s'),
                'to' => date('Y-m-d H:i:s', strtotime("-1 $topic")),
            ];
        }
        if ($When === 'last') {
            return [
                'as' => date('Y-m-d H:i:s', strtotime("-1 $topic")),
                'to' => date('Y-m-d H:i:s', strtotime("-2 $topic")),
            ];
        }
    }

    public function percentage_change($original_value,  $new_value): int // محاسبه درصد تغییر
    {
        if ($original_value > 0 && $new_value > 0) {
            return ($new_value - $original_value) / $original_value * 100;
        }
    }

    public function percentage_item_change($original_value,  $new_value): int // محاسبه درصد تغییر
    {
        if ($original_value > 0 && $new_value > 0) {
            return ($new_value - $original_value) / $original_value * 100;
        }
    }

    public function calculations_mount_see_logs($user_id = false)
    {
        // $shamsi_1400 = [1616272200, 1618947000, 1621625400, 1624303800, 1626982200, 1629660600, 1632342600, 1634934600, 1637526600, 1640118600, 1642710600, 1645302600]; // array key is month shamsi example(فروردین - ساعت 12 شب)
        $shamsi_1400 = [
            '2021-03-21 00:00:00',
            '2021-04-21 00:00:00',
            '2021-05-22 00:00:00',
            '2021-06-22 00:00:00',
            '2021-07-23 00:00:00',
            '2021-08-23 00:00:00',
            '2021-09-23 00:00:00',
            '2021-10-23 00:00:00',
            '2021-11-22 00:00:00',
            '2021-12-22 00:00:00',
            '2022-01-21 00:00:00',
            '2022-02-20 00:00:00',
            '2022-03-20 00:00:00',
        ];
        $farvardin  = $this->seeLogModel->comparison($shamsi_1400[0], $shamsi_1400[1], $user_id);
        $ordebhesht = $this->seeLogModel->comparison($shamsi_1400[1], $shamsi_1400[2], $user_id);
        $khordad    = $this->seeLogModel->comparison($shamsi_1400[2], $shamsi_1400[3], $user_id);
        $tir        = $this->seeLogModel->comparison($shamsi_1400[3], $shamsi_1400[4], $user_id);
        $mordad     = $this->seeLogModel->comparison($shamsi_1400[4], $shamsi_1400[5], $user_id);
        $shhrivar   = $this->seeLogModel->comparison($shamsi_1400[5], $shamsi_1400[6], $user_id);
        $mehr       = $this->seeLogModel->comparison($shamsi_1400[6], $shamsi_1400[7], $user_id);
        $aban       = $this->seeLogModel->comparison($shamsi_1400[7], $shamsi_1400[8], $user_id);
        $azar       = $this->seeLogModel->comparison($shamsi_1400[8], $shamsi_1400[9], $user_id);
        $day        = $this->seeLogModel->comparison($shamsi_1400[9], $shamsi_1400[10], $user_id);
        $bhman      = $this->seeLogModel->comparison($shamsi_1400[10], $shamsi_1400[11], $user_id);
        $esfand     = $this->seeLogModel->comparison($shamsi_1400[11], $shamsi_1400[12], $user_id);

        $array = [
            $farvardin,
            $ordebhesht,
            $khordad,
            $tir,
            $mordad,
            $shhrivar,
            $mehr,
            $aban,
            $azar,
            $day,
            $bhman,
            $esfand,
        ];
        return json_encode($array);
    }

    public function calculations_mount($requested): array
    {
        // $shamsi_1400 = [1616272200, 1618947000, 1621625400, 1624303800, 1626982200, 1629660600, 1632342600, 1634934600, 1637526600, 1640118600, 1642710600, 1645302600]; // array key is month shamsi example(فروردین - ساعت 12 شب)
        $shamsi_1400 = [
            '2021-03-21 00:00:00',
            '2021-04-21 00:00:00',
            '2021-05-22 00:00:00',
            '2021-06-22 00:00:00',
            '2021-07-23 00:00:00',
            '2021-08-23 00:00:00',
            '2021-09-23 00:00:00',
            '2021-10-23 00:00:00',
            '2021-11-22 00:00:00',
            '2021-12-22 00:00:00',
            '2022-01-21 00:00:00',
            '2022-02-20 00:00:00',
            '2022-03-20 00:00:00',
        ]; // array key is month shamsi example(فروردین - ساعت 12 شب)
        // $shamsi_1400_array = array_map(function ($item) {
        //     return strtotime($item);
        // }, $shamsi_1400);
        $farvardin  = $this->orderModel->read_order_between($shamsi_1400[0], $shamsi_1400[1]);
        $ordebhesht = $this->orderModel->read_order_between($shamsi_1400[1], $shamsi_1400[2]);
        $khordad    = $this->orderModel->read_order_between($shamsi_1400[2], $shamsi_1400[3]);
        $tir        = $this->orderModel->read_order_between($shamsi_1400[3], $shamsi_1400[4]);
        $mordad     = $this->orderModel->read_order_between($shamsi_1400[4], $shamsi_1400[5]);
        $shhrivar   = $this->orderModel->read_order_between($shamsi_1400[5], $shamsi_1400[6]);
        $mehr       = $this->orderModel->read_order_between($shamsi_1400[6], $shamsi_1400[7]);
        $aban       = $this->orderModel->read_order_between($shamsi_1400[7], $shamsi_1400[8]);
        $azar       = $this->orderModel->read_order_between($shamsi_1400[8], $shamsi_1400[9]);
        $day        = $this->orderModel->read_order_between($shamsi_1400[9], $shamsi_1400[10]);
        $bhman      = $this->orderModel->read_order_between($shamsi_1400[10], $shamsi_1400[11]);
        $esfand     = $this->orderModel->read_order_between($shamsi_1400[11], $shamsi_1400[12]);

        return   [
            array_sum(array_column($farvardin, $requested . '_total')),
            array_sum(array_column($ordebhesht, $requested . '_total')),
            array_sum(array_column($khordad, $requested . '_total')),
            array_sum(array_column($tir, $requested . '_total')),
            array_sum(array_column($mordad, $requested . '_total')),
            array_sum(array_column($shhrivar, $requested . '_total')),
            array_sum(array_column($mehr, $requested . '_total')),
            array_sum(array_column($aban, $requested . '_total')),
            array_sum(array_column($azar, $requested . '_total')),
            array_sum(array_column($day, $requested . '_total')),
            array_sum(array_column($bhman, $requested . '_total')),
            array_sum(array_column($esfand, $requested . '_total')),

        ];
    }

    public function bestsellers()
    {
        $when     = $this->request->get_param('time');
        $quantity = SessionManager::get('limits_chart_pir') ?? 'grand_total';

        $chart_pir       = $this->orderItemModel->join__orderItem_whit_product_sort($this->between_dates('this', $when), $this->limits_chart_pir, $quantity);
        $chart_pir_total = $this->orderItemModel->read_order_item_between($this->between_dates('this', $when), $quantity);


        // dd($chart_pir[0]['grand_total']);
        if ($quantity == 'grand_total') {
            foreach ($chart_pir as $key => $value) {
                $chart_pir[$key]['comparison'] = '%' . round((($value['grand_total'] - $chart_pir_total) / $chart_pir_total * 100) + 100);
                $chart_pir[$key]['chart_pir_this_to'] = jdate('j F Y');
                $chart_pir[$key]['chart_pir_this_as'] = jdate('j F Y', strtotime("-1 $when"));
                $chart_pir[$key]['chart_pir_last_to'] = jdate('j F Y', strtotime("-1 $when"));
                $chart_pir[$key]['chart_pir_last_as'] = jdate('j F Y', strtotime("-2 $when"));
            }
        }
        if ($quantity == 'quantity_total') {
            foreach ($chart_pir as $key => $value) {
                $chart_pir[$key]['comparison'] = '%' . round((($value['quantity_total'] - $chart_pir_total) / $chart_pir_total * 100) + 100);
                $chart_pir[$key]['chart_pir_this_to'] = jdate('j F Y');
                $chart_pir[$key]['chart_pir_this_as'] = jdate('j F Y', strtotime("-1 $when"));
                $chart_pir[$key]['chart_pir_last_to'] = jdate('j F Y', strtotime("-1 $when"));
                $chart_pir[$key]['chart_pir_last_as'] = jdate('j F Y', strtotime("-2 $when"));
            }
        }

        $data = [
            'chart_pir' => $chart_pir,
        ];
        echo  json_encode($data);
    }

    public function bestsellers_cent()
    {
        $params_time = $this->request->get_param('time');

        $data = [
            'change_item_sale'   => array_values($this->product_change_percentage($params_time)),
        ];
        echo  json_encode($data);
    }

    public function number_view_chart_pri()
    {
        $params = $this->request->get_param('count');
        SessionManager::set('limits_chart_pir', $params);
        return $this->request->redirect('admin/dashboard');
    }

    public function best_selling_products()
    {
        $params = $this->request->params();

        $date = [
            'to' => date('Y-m-d H:i:s', $params['start_at']),
            'as' => date('Y-m-d H:i:s', $params['finish_at']),
        ];
        $report = $this->orderItemModel->join__orderItem_whit_product_sort($date);

        $data = [
            'title'  => 'گزارش محصولات پرفروش',
            'type'   => 'pie',
            'report' => $report,
            'as'     => $params['start_at'],
            'to'     => $params['finish_at'],
            'user'   => Auth::user(),
        ];


        return view('Backend.report.index', $data);
    }
}
