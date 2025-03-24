<?php

namespace App\Repositories\User;


use App\Repositories\AbstractRepo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UserRepo extends AbstractRepo
{

    protected function validate($user, $attributes): array
    {
        return validator($attributes, [
            'name' => [Rule::requiredIf(!$user->exists), 'string', 'max:64'],
            'email' => [Rule::requiredIf(!$user->exists), 'email', Rule::unique('users')->ignoreModel($user)],
            'password' => ['string', 'min:6', 'max:64'],

        ])->validate();
    }

    public function index($user)
    {
        return $user->all();
    }

    /**
     * Update/Create the given entity.
     *
     */
    protected function store($user, $data)
    {
        $user->fill(Arr::except($data, []))->save();
        return $user;
    }

    /**
     * Delete the given entity.
     *
     */
    public function delete($user, $id)
    {
        return $user->find($id)->delete();
    }

    /**
     * Show the given entity.
     *
     * @return void
     */
    public function show($user, $id)
    {
        return $user->find($id);
    }

    /**
     * Restore an entity.
     *
     */
    public function restore($user, $id)
    {
        $user = $user->onlyTrashed()->findOrFail($id);
        $user->restore();
        return $user;
    }

}
