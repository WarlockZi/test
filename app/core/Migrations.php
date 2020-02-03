<?php


namespace app\core;

use app\core\Base\Model;

class Migrations extends Model
{
	public function up()
	{
		$sql =

			"ALTER TABLE vitex_test.category " .
			"ADD COLUMN IF NOT EXISTS " .
			"`act` tinyint (1) default (1) AFTER `id`;"
		;
		$this->pdo->execute($sql);

		$sql =
			"CREATE TABLE IF NOT EXISTS category_prop (" .
			"id int(11) NOT NULL AUTO_INCREMENT," .
			"product_id int(11) NOT NULL ," .
			"prop_id int(11) NOT NULL," .
			"PRIMARY KEY(id)".
			");"
		;
		$this->pdo->execute($sql);

		$sql =
			"CREATE TABLE IF NOT EXISTS category_pic (" .
			"id int(11) NOT NULL AUTO_INCREMENT," .
			"category_id int(11) NOT NULL ," .
			"pic_id int(11) NOT NULL," .
			"PRIMARY KEY(id)".
			");"
		;
		$this->pdo->execute($sql);

		$sql =
			"CREATE TABLE IF NOT EXISTS product_pic (" .
			"id int(11) NOT NULL AUTO_INCREMENT," .
			"product_id int(11) NOT NULL ," .
			"pic_id int(11) NOT NULL," .
			"PRIMARY KEY(id)".
			");"
		;
		$this->pdo->execute($sql);

	}

	public function down()
	{
		$sql = "ALTER TABLE vitex_test . category
		ALTER TABLE `category` DROP `act`;";
		$this->pdo->execute($sql);
	}
}