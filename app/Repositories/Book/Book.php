<?php

namespace App\Repositories\Book;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Repositories\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Repositories\Review\Review;
use App\Repositories\Rating\Rating;
use App\Repositories\User\User;

class Book extends AbstractModel 
{
    use HasFactory , SoftDeletes  ;
 
    public $softDeleting = true;
    protected $hidden = [
        'created_at',
        'updated_at' , 
        'deleted_at'  
    ];

    public $incrementing = true;
    protected $casts = [
        'id' => 'int',
    ];
    protected $keyType = 'int';

    protected $fillable = [

        'title',
        'subtitle',
        'authors',
        'print_type',
        'page_count',
        'publisher',
        'published_date',
        'average_rating',
        'thumbnail',
        'language',
        'categories'
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
        return $this->belongsToMany(User::class, 'user_histories' , 'book_id' , 'user_id' );
    }
}