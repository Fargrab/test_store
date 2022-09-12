<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
           0 => [
               'slug' => 'waiting',
               'title' => 'Ожидает оплаты'
           ],
           1 => [
               'slug' => 'paid',
               'title' => 'Заказ оплачен'
           ],
       ];

        foreach ($statuses as $status) {
            $new_status = new OrderStatus();
            $new_status->slug = $status['slug'];
            $new_status->title = $status['title'];
            $new_status->save();
        }
    }
}
