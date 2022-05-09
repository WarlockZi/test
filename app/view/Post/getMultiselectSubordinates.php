<?php
use \app\view\components\CustomMultiSelect\CustomMultiSelect;

$posts = 	 new CustomMultiSelect([
	'className' => 'type1',
	'field' => 'subordinate',
	'tab' => '.',
	'optionName' => 'name',
	'initialOption' => true,
	'initialOptionValue' => '--',
	'tree' => $array,
	'selected' => $selected,
]);

return $posts->html;