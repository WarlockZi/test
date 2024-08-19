<?php


namespace app\view\Post;


use app\model\Post;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\CustomList;
use app\view\components\Builders\MultiSelectBuilder\MultiSelectBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\CustomMultiSelect\CustomMultiSelect;


class PostView
{

	public $model = Post::class;
	public $html;

	public static function item($id): string
	{
		$view = new self();
		$posts = $view->model::all()->toArray();
		$post = $view->model::with('subordinates','chief')
				->find($id);

		return ItemBuilder::build($post, 'post')
			->pageTitle('Должность : ' . $post->name)
			->del()
			->save()
			->toList('adminsc/post/list')
			->field(
				ItemFieldBuilder::build('id',$post)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name',$post)
					->name('Наименование')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('cheif',$post)
					->name('Руководитель')
					->html(PostView::cheifSelect($posts,$post))
					->get()
			)
			->field(
				ItemFieldBuilder::build('subordinates',$post)
					->name('Подчиненные')
					->html(PostView::subordinatesMultiSelect($posts,$post))
					->get()
			)
			->get();
	}


	public static function cheifSelect($posts,$post): string
	{
		return SelectBuilder::build($posts)
//			->model('post')
			->field('chief')
			->initialOption('', 0)
			->selected($post['chief']['id']??null)
			->excluded($post->id)
			->tab('&nbsp&nbsp')
			->get();
	}

	public static function subordinatesMultiSelect($posts,$post): string
	{
		$ids = $post->subordinates()->pluck('id')->toArray();

		return MultiSelectBuilder::build($posts)
			->field('subordinate')
//			->model('post')
			->initialOption(0, '')
			->selected($ids)
			->excluded($post->id)
			->tab('&nbsp&nbsp')
			->get();
	}

	public function getMultiSelectPosts($array, $selected = []){
		return new CustomMultiSelect([
			'className' => 'type1',
			'field' => 'post_id',
			'tab' => '.',
			'optionName' => 'name',
			'initialOption' => true,
			'initialOptionLabel' => '--',
			'initialOptionValue' => 0,
			'tree' => $array,
			'selected' => $selected,
		]);
	}

	public static function listAll(): string
	{
		$view = new self;
		return CustomList::build($view->model)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->column(
				ListColumnBuilder::build('full_name')
					->name('Полное наим')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->all()
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}

}