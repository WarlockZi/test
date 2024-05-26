<?php


namespace app\Repository;


use app\model\Test;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TestRepository
{
   public static function do(int $id): Model
   {
      return Test::query()
         ->with('questions.answers')
         ->find($id);
   }

   public static function edit(int $id): Model
   {
      return Test::with('questions.answers')
         ->orderBy('sort')
         ->find($id);
   }

   public static function treeAll(): Collection
   {
      return Test::query()
         ->where('test_id', 0)
         ->with('children')
         ->select('id', 'name')
         ->get();
   }
}