<?php

namespace App\Repositories\Rating;

use App\Repositories\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Repositories\User\User;
use App\Repositories\Book\Book;

class Rating extends AbstractModel 
{
    use  SoftDeletes ;
 
    public $softDeleting = true;
    protected $table = 'rating';
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

        'rating_value',
        'user_id',
        'book_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }

}