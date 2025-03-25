<?php

namespace App\Admin\Controllers;

use App\Repositories\Rating\Rating;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RatingController extends AdminController
{
    protected $title ='Rating of Books';

    protected function grid()
    {
        $grid = new Grid(new Rating());

        $grid->column('id', __('Id'));
        $grid->column('rating_value', __('rating_value'));
        $grid->column('user.name');
        $grid->column('book.title');
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Rating::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('rating_value', __('rating_value'));
        $show->field('user.name');
        $show->field('book.title');
       // $show->field('user_id', __('user_id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Rating());
        $form->textarea('content', __('content'));

      //  $form->textarea('user.name');
     //   $form->textarea('book.title');
        return $form;
    }
}