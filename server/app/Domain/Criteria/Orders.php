<?php

namespace App\Domain\Criteria;

final class Orders
{
    public $orders = [];

    public function __construct(
        $orders,
    ) {
        $this->orders = $this->format($orders);
    }

    private function format($orders)
    {
        foreach ($orders as $filter) {
            $this->orders[] = [
                "orderBy" => $filter["orderBy"],
                "orderType" => $filter["orderType"],
            ];
        }
    }

}
