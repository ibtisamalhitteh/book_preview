<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Repositories\Book\Book;
use App\Repositories\Book\BookRepo;

class GoogleBooksApiController extends Controller
{

    use ApiResponser;
    private BookRepo $bookRepository;
    private $client;
    private $google_book_api_url;

    public function __construct()
    {
        $this->bookRepository = new BookRepo;
        $this->client = new \GuzzleHttp\Client();
        $this->google_book_api_url = env('GOOGLE_BOOKS_API_URL');
        if(empty($this->google_book_api_url )){
            $this->google_book_api_url  = "https://www.googleapis.com/books/v1/volumes";
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function fetchBooks($batch_size)
    {
        try {
             
             $params['maxResults'] = 40;

              $response = $this->client->request('GET', $this->google_book_api_url, [
                'query'  => ['q' => 'batch_size:'.$batch_size],
                'http_errors' => false,
                ]);

        //dd($response);
               $status = $response->getStatusCode();
               if($status == 200){
                    $res = json_decode($response->getBody(), true);
                    $totalItems = intval($res['totalItems']);
                    
                    return $this->extractBook($res);
                    return $this->success($response->getBody() , 'Successfully get books', 200); 
                }else{
                    return $this->error('Invalid response. Status: '.$status.'. Body: '.$response->getBody() , 400) ;

                }

        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->error($message , 400) ;
        }

    }



    private function extractBook($res)
    {
        $items = $res['items'];
        foreach($items as $item){
            $input['published_date'] = (string)$this->getOrDefault($item['volumeInfo'], 'publishedDate', null);
            //list($publishedDate, $publishedDateFormat) = $this->parseDate($publishedDate);
            $input['title'] = $item['volumeInfo']['title'];
            $input['subtitle'] = json_encode($this->getOrDefault($item['volumeInfo'], 'subtitle', null));
            $input['authors'] = json_encode($this->getOrDefault($item['volumeInfo'], 'authors', null));
            $input['print_type'] = json_encode($this->getOrDefault($item['volumeInfo'], 'printType', null));
            $input['page_count'] = intval($this->getOrDefault($item['volumeInfo'], 'pageCount', null));
            $input['average_rating'] = json_encode($this->getOrDefault($item['volumeInfo'], 'averageRating', null));
            $input['thumbnail'] = $item['volumeInfo']['imageLinks']['thumbnail'];
            $input['language'] = json_encode($this->getOrDefault($item['volumeInfo'], 'language', null));
            $input['categories'] = json_encode($this->getOrDefault($item['volumeInfo'], 'categories', []));
            $input['publisher'] = json_encode($this->getOrDefault($item['volumeInfo'], 'publisher', null));

            $this->bookRepository->create(new Book(), $input);

        }
        return true;
    }

    /**
     * Parse the publication date.
     *
     * @param string $rawDate
     *
     * @return array The publication in DateTime and the date format
     */
    private function parseDate($rawDate)
    {
        foreach (['Y-m-d', 'Y-m', 'Y'] as $dateFormat) {
            $publishedDate = DateTime::createFromFormat($dateFormat.'|', $rawDate);
            if ($publishedDate !== false) {
                break;
            }
        }

        if ($publishedDate === false) {
            $publishedDate = null;
        }

        return [$publishedDate, $dateFormat];
    }

    private function getOrDefault($array, $key, $default)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }

    /**
     * Check if a given ISBN is valid.
     *
     * @param string $isbn
     *
     * @return bool
     */
    private function isValidISBN($isbn)
    {
        return preg_match('/[0-9]{10,13}/', $isbn);
    }
}
