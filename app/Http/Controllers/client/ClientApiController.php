<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookCategoryResource;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientApiController extends Controller
{

    /**
     * Display the Book Categories list.
     */
    public function bookCategories(): AnonymousResourceCollection
    {
        return BookCategoryResource::collection(BookCategory::all());
    }
}
