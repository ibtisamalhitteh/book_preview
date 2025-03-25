<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Repositories\Book\Book;
use App\Repositories\Book\BookRepo;

use App\Repositories\Rating\Rating;
use App\Repositories\Rating\RatingRepo;

use App\Repositories\Review\Review;
use App\Repositories\Review\ReviewRepo;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookResource;

class BookController extends Controller
{

   use ApiResponser;
    private BookRepo $bookRepository;
    private ReviewRepo $reviewRepository;
    private RatingRepo $ratingRepository;

    public function __construct()
    {
        $this->bookRepository = new BookRepo;
        $this->reviewRepository = new ReviewRepo;
        $this->ratingRepository = new RatingRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ['books' => BookResource::collection(Book::all())];
        return $this->success($data , 'Successfully aget dmins List', 200); 
    }

    /**
     * This is function add review for book
     */
    public function review(Request $request)
    {
        try {
            $input = $request->only('book_id', 'content');
            $input['user_id'] = $request->user('api')->id;
            $this->reviewRepository->create(new Review() , $input);
            $data = [];
            return $this->success($data, "Review added successfully", 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->error($message , 400) ;
        }
    }

    /**
     * This is function return reviews for book by id
     */
    public function getBookReviews(Request $request , $book_id)
    {
        try {
            $book = Book::where('id',$book_id)->with('review')->get();
            $data = [ "reviews" => $book->review()->get()];
            return $this->success($data, "get book reviews list successfully", 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->error($message , 400) ;
        }
    }

    /**
     * This is function add rating for book
     */
    public function rating(Request $request)
    {
        try {
            $input = $request->only('book_id', 'rating_value');
            $input['user_id'] = $request->user('api')->id;
            $this->ratingRepository->create(new Rating() , $input);
            $data = [];
            return $this->success($data, "Rating added successfully", 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->error($message , 400) ;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show($id,Request $request)
    {
        try {
            $book = Book::find($id);
            
            $data = ['book' => BookResource::make($book)];
            $user = Auth::user('api');
            $user->userhistory()->detach($book);
            $user->userhistory()->attach($book ); 
            return $this->success($data, "Book get successfully", 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->error($message , 400) ;
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = Book::find($id);
            $this->bookRepository->delete($book);
            return $this->success(null , 'Book delete success' , 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->error($message , 400) ;
        }
    }
}
