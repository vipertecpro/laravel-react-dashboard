<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class BooksController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        try {
            return Inertia::render('be/Books/List', [
                'user' => $request->user(),
                'pageTitle' => 'Books List',
                'pageDescription' => 'A list of all the books.'
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }
    /**
     * Book Create Form
     */
    public function create(Request $request): Response
    {
        try {
            return Inertia::render('be/Books/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Create Book',
                'pageDescription' => '',
                'pageData' => null,
                'formUrl' => route('dashboard.be.books.storeUpdate')
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }

    /**
     * Book Create Form
     */
    public function edit($bookId , Request $request): Response
    {
        try {
            $getBookInfo = Book::where('id',$bookId)->first();
            return Inertia::render('be/Books/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Edit Book',
                'pageDescription' => '',
                'pageData' => $getBookInfo,
                'formUrl' => route('dashboard.be.books.storeUpdate',$bookId)
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }
    /**
     * Handle book form.
     *
     * @throws ValidationException
     */
    public function storeUpdate(Request $request, $userId = 0): RedirectResponse
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'ISBN_10'   => 'required|string|max:255',
            'ISBN_13'   => 'required|string|max:255',
            'author'    => 'required|string|max:255',
        ]);
        Book::updateOrCreate([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
        ],[
            'ISBN_10' => $request->ISBN_10,
            'ISBN_13' => $request->ISBN_13,
            'author'  => $request->author,
        ]);
        return redirect()->route('dashboard.be.books.list');
    }
    /**
     * Remove Book
     * */
    public function remove($book_id): RedirectResponse
    {
        Book::where('id',$book_id)->delete();
        return redirect()->route('dashboard.be.books.list');
    }
}
