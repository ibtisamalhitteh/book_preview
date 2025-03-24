<?php

namespace App\Repositories\Review;

use App\Repositories\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Repositories\User\User;
use App\Repositories\Book\Book;

class Review extends AbstractModel 
{
    use HasFactory , SoftDeletes ;
 
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

        'content',
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