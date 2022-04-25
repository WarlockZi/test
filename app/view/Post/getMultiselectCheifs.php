<?php
use \app\view\components\CustomMultiSelect\CustomMultiSelect;

$posts =  new CustomMultiSelect([
	'className' => 'type1',
	'tab' => '.',
	'fieldName' => 'name',
	'initialOption' => true,
	'initialOptionValue' => '--',
	'field' => 'chief',
	'tree' => $array,
	'selected' => $selected,
]);

return $posts->html;