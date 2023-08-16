<?php
namespace App\Http\Controllers\be;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class BookCategoriesController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        try {
            return Inertia::render('be/BookCategories/List', [
                'user' => $request->user(),
                'pageTitle' => 'Book Categories List',
                'pageDescription' => 'A list of all the book categories.'
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }
    /**
     * Role Create Form
     */
    public function create(Request $request): Response
    {
        try {
            return Inertia::render('be/BookCategories/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Create Book Category',
                'pageDescription' => '',
                'pageData' => null,
                'formUrl' => route('dashboard.be.bookCategories.storeUpdate'),
                'book_categories' => BookCategory::where('parent_id','=',0)->where('is_active','=',1)->get()
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }

    /**
     * Role Create Form
     */
    public function edit($book_category_id , Request $request): Response
    {
        try {
            $getBookCategoryInfo = BookCategory::where('id',$book_category_id)->first();
            return Inertia::render('be/BookCategories/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Edit Book Category',
                'pageDescription' => '',
                'pageData' => $getBookCategoryInfo,
                'formUrl' => route('dashboard.be.bookCategories.storeUpdate',$book_category_id),
                'book_categories' => BookCategory::where('parent_id','=',0)->where('is_active','=',1)->where('id','!=',$book_category_id)->get()
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }
    /**
     * Handle an users form.
     *
     * @throws ValidationException
     */
    public function storeUpdate(Request $request, $book_category_id = 0): RedirectResponse
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:255',
            'is_active'     => 'required|integer|digits_between: 0,1',
            'parent_id'     => 'nullable|integer',
        ]);
        $storageFolder = 'bookCategories';
        if($request->hasFile('icon_file_path')){
            $file = $request->file('icon_file_path');
            $fileName =  Str::random(5).'__'.date('d_m_y_h_i_s').'.'.$file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs($storageFolder, $file,$fileName);
            $fileNameWithPath = 'storage/'.$storageFolder.$fileName;
        }else{
            $fileNameWithPath = null;
        }
        BookCategory::updateOrCreate([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
        ],[
            'icon_file_path' => $fileNameWithPath,
            'description'    => $request->get('description'),
            'parent_id'      => $request->get('parent_id'),
            'is_active'      => $request->get('is_active'),
        ]);
        return redirect()->route('dashboard.be.bookCategories.list');
    }
    /**
     * Remove Book category
     * */
    public function remove($book_category_id): RedirectResponse
    {
        BookCategory::where('id',$book_category_id)->delete();
        return redirect()->route('dashboard.be.bookCategories.list');
    }
    /**
     * Remove All Book category
     * */
    public function removeAll(): RedirectResponse
    {
        BookCategory::query()->delete();
        return redirect()->route('dashboard.be.bookCategories.list');
    }
}
