<?php

namespace App\Repositories\Rating;


use App\Repositories\AbstractRepo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class RatingRepo extends AbstractRepo
{

    protected function validate($rating, $attributes): array
    {
        return validator($attributes, [
            
            'rating_value' => ['string'],
            'user_id' => [],
            'book_id' => []

        ])->validate();
    }

    public function index($rating)
    {
        return $rating->all();
    }

    /**
     * Update/Create the given entity.
     *
     */
    protected function store($rating, $data)
    {
        $rating->fill(Arr::except($data, []))->save();
        return $rating;
    }

    /**
     * Delete the given entity.
     *
     */
    public function delete($rating, $id)
    {
        return $rating->find($id)->delete();
    }

    /**
     * Show the given entity.
     *
     * @return void
     */
    public function show($rating, $id)
    {
        return $rating->find($id);
    }

    /**
     * Restore an entity.
     *
     */
    public function restore($rating, $id)
    {
        $rating = $rating->onlyTrashed()->findOrFail($id);
        $rating->restore();
        return $rating;
    }

}
