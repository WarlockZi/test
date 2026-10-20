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

//    public function actionToorder(): void
//    {
//        if ($this->ajax) {
//            $form       = $this->ajax['form'];
//            $sess       = $_SESSION['phpSession'];
//            $orderItems = OrderItem::where('sess', $sess)->get();
//            $lead       = Lead::create($form);
//            $orders      = orders::create($form);
//            $orders->lead()->associate($lead);
//            $orders->save();
//            foreach ($orderItems as $orderItem) {
//                $orderItem->orders()->associate($orders);
//                $orderItem->save();
//            }
//            response()->json(['ok']);
//        }
//    }

    public function actionDelete(IRequest $request): void
    {
        $product_id = $this->ajax['product_id'];
        $sess       = $this->ajax['sess'];

        if (!$product_id) response()->json(['msg' => 'No id']);
        $trashed = $this->repo->deleteItem($sess, $product_id, $unit_ids);

        if ($trashed) {
            response()->json(['ok' => true, 'popup' => 'Удален']);
        }
        response()->popup('Не удален');

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
