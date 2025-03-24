<?php

namespace App\Repositories\Book;


use App\Repositories\AbstractRepo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class BookRepo extends AbstractRepo
{

    protected function validate($book, $attributes): array
    {
        return validator($attributes, [
            'title' => ['string'],
            'subtitle' => ['string'],
            'authors' => ['string'],
            'print_type' => ['string'],
            'page_count' => [],
            'publisher' => ['string'],
            'published_date' => ['string'],
            'average_rating' => [],
            'thumbnail' => ['string'],
            'language' => ['string'],
            'categories' => ['string']
        ])->validate();
    }

    public function index($book)
    {
        return $book->all();
    }

    /**
     * Update/Create the given entity.
     *
     */
    protected function store($book, $data)
    {
        $book->fill(Arr::except($data, []))->save();
        return $book;
    }

    /**
     * Delete the given entity.
     *
     */
    public function delete($book, $id)
    {
        return $book->find($id)->delete();
    }

    /**
     * Show the given entity.
     *
     * @return void
     */
    public function show($book, $id)
    {
        return $book->find($id);
    }

    /**
     * Restore an entity.
     *
     */
    public function restore($book, $id)
    {
        $book = $book->onlyTrashed()->findOrFail($id);
        $book->restore();
        return $book;
    }

}
