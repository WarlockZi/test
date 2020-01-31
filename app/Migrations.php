<?php


namespace app;

use app\core\Base\Model;

class Migrations extends Model
{
	public function up()
	{
		$sql =
			"ALTER TABLE vitex_test.category ".
  			"ADD COLUMN IF NOT EXISTS ".
  			"`act` tinyint (1) default (1) AFTER `id`;";

		$this->pdo->execute($sql);
	}

	public function down()
	{
		$sql = "ALTER TABLE vitex_test.category
		ALTER TABLE `category` DROP `act`;";
		$this->pdo->execute($sql);
	}
}