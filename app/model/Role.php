<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'sort'
    ];

	public function users(){

	}

}