<?php

namespace App\Business\Users;

use App\Business\AbstractRepo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UserRepo extends AbstractRepo
{
    protected function validate($user, $attributes): array
    {
        return validator($attributes, [
            'name' => ['string', 'min:6', 'max:64'],
            'email' => [Rule::requiredIf(!$user->exists), 'email', Rule::unique('users')->ignoreModel($user)],
            'password' => ['string', 'min:6', 'max:64'],
            'activated' => ['boolean','nullable'],
			'otp_code' => ''
            
        ])->validate();
    }

    protected function store($user, $data)
    {
        $data['otp_code'] = random_int(100000, 999999);
        $data['salt'] = Str::random(10); 
        $user->fill(Arr::except($data, []))->save();
        return $user;
    }

    public function delete($user)
    {
        $user->delete();
    }


}
