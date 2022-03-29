<?php

namespace App\Listeners;

use IndexController;
use Orders;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Products;
use Settings;

class NotificationsListeners extends Injectable
{
    public function setDefault(
        Event $event,
        IndexController $component,
        $id
    ) {
        $product = Products::find($id);
        $settings = Settings::findFirst();

        if ($settings->title == 1) {
            $product[0]->name = $product[0]->name . $product[0]->tags;
            $product[0]->update();
        }

        if ($settings->price != null) {
            if ($product[0]->price == null || $product[0]->price == 0) {
                $product[0]->price = $settings->price;
                $product[0]->update();
            }
        }

        if ($settings->stock != null && ($product[0]->stock == null || $product[0]->stock == 0)) {
            $product[0]->stock = $settings->stock;
            $product[0]->update();
        }
    }

    public function setDefaultZipcode(
        Event $event,
        IndexController $component,
        $id
    ) {
        $settings = Settings::findFirst();
        $order = Orders::findFirst($id);

        if ($settings->zipcode != null && ($order->zipcode == null || $order->zipcode == 0)) {
            $order->zipcode = $settings->zipcode;
            $order->update();
        }
    }
}
