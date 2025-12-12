<?php

namespace app\controller\Admin;


use app\action\admin\PropertyAction;
use app\model\Propertable;
use app\model\Property;
use app\service\Router\IRequest;
use app\view\Property\PropertyView;
use JetBrains\PhpStorm\NoReturn;


class PropertyController extends AdminscController
{

    public function __construct(
        protected PropertyAction $actions,
        public string            $model = Property::class,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->showTable();
    }

    public function actionEdit(IRequest $request)
    {
        if (!$request->id) header('Location: /adminsc/property');

        $catItem = PropertyView::edit($request->id);
        view('admin.property.edit', compact('catItem'));
    }

    public function actionDelete(IRequest $request): void
    {
        Propertable::where('property_id', $request->body['id'])->delete();
//        parent::actionDelete();
    }

}
