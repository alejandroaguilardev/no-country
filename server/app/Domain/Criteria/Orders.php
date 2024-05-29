<?php

namespace App\Domain\Criteria;

final class Orders
{
    public array $orders = [];

    public function __construct(
        $orders,
    ) {
        $this->format($orders);
    }

    private function format($orders)
    {
        foreach ($orders as $order) {
            $this->orders[] = [
                "orderBy" => $order["orderBy"],
                "orderType" => $order["orderType"],
            ];
        }
    }

    public function toArray(): array
    {
        return $this->orders;
    }

}
