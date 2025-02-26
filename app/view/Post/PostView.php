<?php


namespace app\view\Post;


use app\model\Post;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
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
			->toList('adminsc/post/table')
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

	public static function index(): string
	{
		return Table::build(
            Post::with('chief')->get()
        )
            ->pageTitle('Должности')
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get()
			)
			->column(
				ColumnBuilder::build('name')
					->name('Краткое наим')
					->contenteditable()
                    ->class('left')
					->width('100px')
					->get()
			)

			->column(
				ColumnBuilder::build('full_name')
					->name('Полное наим')
					->contenteditable()
                    ->class('left')
					->width('250px')
					->get()
			)
            ->column(
                ColumnBuilder::build('chief')
                    ->callback(fn($post)=>$post->chief->name??'')
                    ->class('left')
                    ->name('Подчиняется')
                    ->width('1fr')
                    ->get()
            )
			->edit()
			->del()
			->addButton()
			->get();
	}

}