<?php


namespace App\Services;


use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderStatus;
use App\Models\Product;

class OrderService
{
    /**
     * @var float
     */
    public float $sum;
    /**
     * @var string
     */
    public string $error;

    /**
     * @param array $data
     * @return array
     */
    public function createOrder(array $data): array
    {
        $result = [
            'error' => true
        ];
        $check = $this->checkIssetCounts($data['order']);
        if ($check) {
            try {
                $order = new Order();
                $order->user_id = $data['user_id'];
                foreach ($data['order'] as $item) {
                    $product = Product::find($item['product_id']);

                    $new_item = new OrderItems();
                    $new_item->order_id = $item['order_id'];
                    $new_item->product_id = $item['product_id'];
                    $new_item->count = $item['count'];
                    $new_item->reserve_price = $product->price;
                    $new_item->save();

                    $product->reserve = $new_item->count;
                    $product->save();
                }

                $status = OrderStatus::where('slug', 'await')->first();
                $order->order_status_id = $status->id;
                $order->save();

                $result = [
                    'error' => false,
                    'message' => 'Заказ успешно создан. Номер заказа ' . $order->id
                ];
            } catch (\Exception $exception) {
                $result = [
                    'message' => 'Серверная ошибка попробуйте позднее',
                    'develop_message' => $exception->getMessage()
                ];
            }
        } else {
            $result = [
                'message' => $this->error
            ];
        }

        return $result;
    }

    /**
     *
     * @param array $data
     * @return array
     */
    public function approveOrder(array $data): array
    {
        $result = [
            'error' => true
        ];
        $order = Order::find($data['order_id']);
        if($order->orderItems->count() > 0) {
            $check = $this->calculateAndCheckBalance($data['order_id']);
            if ($check) {
                try {
                    $user = $order->user;
                    $user->balance = number_format($user->balance - $this->sum, 2, '.');
                    $user->save();

                    $order_status = OrderStatus::where('slug', 'paid')->first();
                    $order->order_status_id = $order_status->id;
                    $order->save();

                    $this->deletePaysProducts($order->id);

                    $result = [
                        'error' => false,
                        'message' => 'Статус заказа №' . $order->id . ' - ' . $order_status->title
                    ];
                } catch (\Exception $exception) {
                    $result = [
                        'message' => 'Серверная ошибка попробуйте позднее',
                        'develop_message' => $exception->getMessage()
                    ];
                }
            }
        } else {
            $result['message'] = 'В заказе нет товаров';
        }
        return $result;
    }

    /**
     * @param array $order
     * @return bool
     */
    public function checkIssetCounts(array $order): bool
    {
        $check = true;

        foreach ($order as $item) {
            $product = Product::find($item['product_id']);
            if ($product->count - $product->reserve >= $item['count']) {
                continue;
            } else {
                $check = false;
                $this->error = 'Для заказа товара ' . $product->title . ' доступно только ' . $product->count - $product->reserve . 'шт.';
                break;
            }
        }

        return $check;
    }

    /**
     * @param int $order_id
     * @return false
     */
    public function calculateAndCheckBalance(int $order_id): bool
    {
        $result = false;
        $order = Order::find($order_id);
        $balance = $order->user->balance;
        $sum = 0.00;
        foreach ($order as $item) {
            $sum += ($item->reserve_price * $item->count);
        }
        if ($sum <= $balance) {
            $this->sum = $sum;
            $result = true;
        } else {
            $this->error = 'Недостаточно средств на счёте';
        }

        return $result;
    }

    /**
     * @param int $id
     */
    public function deletePaysProducts(int $id)
    {
        $order = Order::find($id);
        foreach ($order->orderItem as $item) {
            $product = $item->product;
            $product->reserve = $product->reserve - $item->count;
            $product->count = $product->count - $item->count;
            $product->save();
        }
    }
}
