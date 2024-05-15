<?php

namespace app\view\share;



use Illuminate\Database\Eloquent\Collection;

class ShippableUnitsTableFactory
{
    private ShippableUnitsTable $self;
    private Collection $units;
    private ShippableUnitsTable $table;
    public function __construct(Collection $units)
    {
        $this->units = $units;
    }

    public static function create(string $module, Collection $units):string
    {
        $self = new self($units);
        $self->table = new ShippableUnitsTable($units);
        if ($module === 'product') {
            return $self->table->blueButton();
        } elseif ($module === 'category') {
            return $self->table->blueButton();

        }
        return $self->table->get();;//cart

    }

}