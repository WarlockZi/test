<?php

namespace app\Services\Test;

use app\core\FS;
use app\model\Category;
use app\model\Test;
use app\Repository\CategoryRepository;
use app\Repository\TestRepository;
use app\view\Accordion\AccordionView;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\TreeOptionsBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TestService
{
	public function __construct($id)
	{
	}

}