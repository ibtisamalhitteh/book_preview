<?php

namespace App\Repositories\User;


use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Repositories\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;

use App\Repositories\Review\Review;
use App\Repositories\Rating\Rating;
use App\Repositories\Book\Book;

class User extends AbstractModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes , Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
 
    public $softDeleting = true;
    protected $hidden = [
        'created_at',
        'updated_at' , 
        'remember_token', 
        'deleted_at'  
    ];

    public $incrementing = true;
    protected $casts = [
        'id' => 'int',
    ];
    protected $keyType = 'int';

    protected $fillable = [

        'name',
        'password',
        'email',
        'email_verified_at'
    ];

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
    
    public function history()
    {
        return $this->belongsToMany(Book::class, 'user_histories' , 'user_id' , 'book_id' );
    }
/*
    protected function password(): Attribute
    {
        return new Attribute(
            set: fn ($password) => Hash::make($password),
        );
    }
*/

}