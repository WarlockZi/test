<?php

namespace app\controller\Admin;


use app\model\Lead;
use app\model\Order;
use app\model\OrderItem;
use app\repository\OrderitemRepository;
use app\service\Response;
use app\view\Order\OrderView;


class OrderitemController extends AdminscController
{
    public function __construct(
        protected OrderView           $orderView = new OrderView(),
        protected OrderitemRepository $repo = new OrderitemRepository(),
    )
    {
        parent::__construct();
    }

    public function actionToorder(): void
    {
        if ($this->ajax) {
            $form       = $this->ajax['form'];
            $sess       = $_SESSION['phpSession'];
            $orderItems = OrderItem::where('sess', $sess)->get();
            $lead       = Lead::create($form);
            $order      = Order::create($form);
            $order->lead()->associate($lead);
            $order->save();
            foreach ($orderItems as $orderItem) {
                $orderItem->order()->associate($order);
                $orderItem->save();
            }
            response()->json(['ok']);
        }
    }

    public function actionDelete(): void
    {
        $product_id = $this->ajax['product_id'];
        $sess       = $this->ajax['sess'];

        if (!$product_id) response()->json(['msg' => 'No id']);
        $trashed = $this->repo->deleteItem($sess, $product_id, $unit_ids);

        if ($trashed) {
            response()->json(['ok' => true, 'popup' => 'Удален']);
        }
        Response::exitWithPopup('Не удален');

    }


    public function actionIndex(): void
    {
    }

    public function actionEdit(): void
    {
        $this->view  = 'table';
        $orderitemId = $this->route->id;
        $orderitems  = $this->repo->edit($orderitemId);
        $table       = $this->orderView->orderItemEdit($orderitems['oItems']);
        $this->setVars(compact('table'));
    }


}
