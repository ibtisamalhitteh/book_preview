<?php

namespace App\Admin\Controllers;

use App\Repositories\Book\Book;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BookController extends AdminController
{
    protected $title ='Books';

    protected function grid()
    {
        $grid = new Grid(new Book());

        $grid->column('id', __('Id'));
        $grid->column('thumbnail', __('thumbnail'))->image();
        $grid->column('title', __('title'));
       // $grid->column('subtitle', __('subtitle'));
        $grid->column('authors', __('authors'));
        $grid->column('print_type', __('print_type'));
        $grid->column('page_count', __('page_count'));
        $grid->column('publisher', __('publisher'));
        $grid->column('published_date', __('published_date'));
       // $grid->column('average_rating', __('average_rating'));
        
        $grid->column('language', __('language'));
        $grid->column('categories', __('categories'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Book::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('title'));
        $show->field('subtitle', __('subtitle'));
        $show->field('authors', __('authors'));
        $show->field('print_type', __('print_type'));
        $show->field('page_count', __('page_count'));
        $show->field('publisher', __('publisher'));
        $show->field('published_date', __('published_date'));
        $show->field('average_rating', __('average_rating'));
        $show->field('thumbnail', __('thumbnail'));
        $show->field('language', __('language'));
        $show->field('categories', __('categories'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Book());

        $form->textarea('title', __('Title'));
        $form->textarea('subtitle', __('Subtitle'));
        $form->textarea('authors', __('Authors'));
        $form->textarea('print_type', __('Print Type'));
        $form->textarea('page_count', __('Page Count'));
        $form->textarea('publisher', __('Publisher'));
        $form->textarea('published_date', __('Published Date'));
        $form->textarea('average_rating', __('Average Rating'));
        $form->image('thumbnail', __('Thumbnail'));
        $form->textarea('language', __('Language'));
        $form->textarea('categories', __('Categories'));
        // rating fields
        $form->hasMany('rating', function (Form\NestedForm $form) {
            $form->text('rating_value');
           // $form->image('body');
        });
        return $form;
    }
}