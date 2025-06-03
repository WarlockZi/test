<?php


namespace app\controller\Admin;


use app\action\admin\UnitAction;

use app\model\Unit;
use app\repository\UnitRepository;
use app\service\Router\IRequest;
use app\view\Unit\UnitFormView;
use JetBrains\PhpStorm\NoReturn;


class UnitController extends AdminscController
{
    protected string $model = Unit::class;

    public function __construct(
        protected UnitAction $actions,
        private UnitRepository  $repo
    )
    {
        parent::__construct();
        $this->repo = new UnitRepository();
    }

    public static function attachUnit(array $req)
    {
        list($pivot, $baseUnit, $old_id, $new_id) = $req;
        $res = $baseUnit->units()
            ->attach(
                $new_id, [
                    'multiplier' => $pivot['multiplier'],
                    'product_id' => $pivot['product_id']]
            );
        return true;
    }

    public static function detachUnit(array $req)
    {
        list($pivot, $baseUnit, $old_id, $new_id) = $req;

        if ($baseUnit->units()
            ->wherePivot('product_id', $pivot['product_id'])
            ->detach($old_id)
        ) return true;
        return false;
    }

    public function actionAttachUnit()
    {
        $this->repo->attachUnit($this->ajax);
    }

    public function actionChangeUnit()
    {
        $this->repo->changeUnit($this->ajax);
    }

    public function actionDetachUnit()
    {
        $this->repo->detachUnit($this->ajax);
    }

    public function actionEdit(IRequest $request)
    {
        $id = $request->id;
        if ($id) {
            $unit     = UnitRepository::edit($id);
            $unitItem = UnitFormView::editItem($unit);
            $this->setVars(compact('unit', 'unitItem'));
        }
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->showTable();
    }

}