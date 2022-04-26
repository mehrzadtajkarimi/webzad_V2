<?php

namespace App\Services\Basket\Contract;

interface   BasketContract
{
    public function add(array $item);
    public function remove(int $item_id);
    public function total(); //total contract
    public function reset();
    public function items();
    public function count();
}
