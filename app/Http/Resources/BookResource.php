<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =[

            "id"=> $this->id,
            "title"=> $this->title,
            "subtitle"=> $this->subtitle,
            "authors"=> $this->authors,
            "print_type"=> $this->print_type,
            "page_count"=> $this->page_count,
            "publisher"=> $this->publisher,
            "published_date"=> $this->published_date,
            "average_rating"=> $this->average_rating,
            "thumbnail"=> $this->thumbnail,
            "language"=> $this->language,
            "categories"=> $this->categories,
            "avg_rating"=> $this->avgRating(),
            "review" => $this->review()->get(),

        ];
        return $data; //parent::toArray($request);
    }
}
