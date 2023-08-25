<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Models\BookReview;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class BookReviewsController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        try {
            return Inertia::render('be/BookReviews/List', [
                'user' => $request->user(),
                'pageTitle' => 'Book Reviews List',
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
            return Inertia::render('be/BookReviews/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Create Book Review',
                'pageDescription' => '',
                'pageData' => null,
                'formUrl' => route('dashboard.be.bookReviews.storeUpdate')
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }

    /**
     * Book Create Form
     */
    public function edit($book_review_id , Request $request): Response
    {
        try {
            $getBookInfo = BookReview::where('id',$book_review_id)->first();
            return Inertia::render('be/BookReviews/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Edit Book Review',
                'pageDescription' => '',
                'pageData' => $getBookInfo,
                'formUrl' => route('dashboard.be.bookReviews.storeUpdate',$book_review_id)
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
    public function storeUpdate(Request $request, $book_review_id = 0): RedirectResponse
    {
        $request->validate([
            'status'     => 'required|string|max:255',
        ]);
        BookReview::where('id',$book_review_id)->update([
            'status' => $request->get('status'),
        ]);
        return redirect()->route('dashboard.be.bookReviews.list');
    }
    /**
     * Remove Book
     * */
    public function remove($book_review_id): RedirectResponse
    {
        BookReview::where('id',$book_review_id)->delete();
        return redirect()->route('dashboard.be.bookReviews.list');
    }
}
