<?php

namespace App\Repositories\Review;


use App\Repositories\AbstractRepo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ReviewRepo extends AbstractRepo
{

    protected function validate($review, $attributes): array
    {
        return validator($attributes, [
            
            'content' => ['string'],
            'user_id' => [],
            'book_id' => []

        ])->validate();
    }

    public function index($review)
    {
        return $review->all();
    }

    /**
     * Update/Create the given entity.
     *
     */
    protected function store($review, $data)
    {
        $review->fill(Arr::except($data, []))->save();
        return $review;
    }

    /**
     * Delete the given entity.
     *
     */
    public function delete($review, $id)
    {
        return $review->find($id)->delete();
    }

    /**
     * Show the given entity.
     *
     * @return void
     */
    public function show($review, $id)
    {
        return $review->find($id);
    }

    /**
     * Restore an entity.
     *
     */
    public function restore($review, $id)
    {
        $review = $review->onlyTrashed()->findOrFail($id);
        $review->restore();
        return $review;
    }

}
