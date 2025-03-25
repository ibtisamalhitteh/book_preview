<?php

namespace App\Admin\Controllers;

use App\Repositories\Review\Review;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReviewsController extends AdminController
{
    protected $title ='Review of Books';

    protected function grid()
    {
        $grid = new Grid(new Review());

        $grid->column('id', __('Id'));
        $grid->column('content', __('content'));
        $grid->column('user.name');
        $grid->column('book.title');
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Review::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('content', __('content'));
        $show->field('user.name');
        $show->field('book.title');
       // $show->field('user_id', __('user_id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Review());

        $form->textarea('content', __('content'));

      //  $form->textarea('user.name');
     //   $form->textarea('book.title');
        return $form;
    }
}