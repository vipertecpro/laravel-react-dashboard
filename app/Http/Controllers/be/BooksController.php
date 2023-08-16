<?php

namespace App\Http\Controllers\be;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BooksController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        return Inertia::render('be/Books/List', [
            'user' => $request->user(),
            'pageTitle' => 'Book List',
        ]);
    }
}
