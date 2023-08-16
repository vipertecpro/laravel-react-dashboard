<?php

namespace App\Http\Controllers\be;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BookCategory;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class BlogCategoriesController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        try {
            return Inertia::render('be/BlogCategories/List', [
                'user' => $request->user(),
                'pageTitle' => 'Blog Categories List',
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
        return Inertia::render('be/BlogCategories/Form', [
            'user' => $request->user(),
            'pageTitle' => 'Create Blog Category',
            'pageDescription' => '',
            'pageData' => null,
            'formUrl' => route('dashboard.be.blogCategories.storeUpdate'),
            'blog_categories' => BlogCategory::where('parent_id','=',0)->where('is_active','=',1)->get()
        ]);
    }

    /**
     * Role Create Form
     */
    public function edit($blog_category_id , Request $request): Response
    {
        $getRoleInfo = BlogCategory::where('id',$blog_category_id)->first();
        return Inertia::render('be/BlogCategories/Form', [
            'user' => $request->user(),
            'pageTitle' => 'Edit Blog Category',
            'pageDescription' => '',
            'pageData' => $getRoleInfo,
            'formUrl' => route('dashboard.be.blogCategories.storeUpdate',$blog_category_id),
            'blog_categories' => BlogCategory::where('parent_id','=',0)->where('is_active','=',1)->where('id','!=',$blog_category_id)->get()
        ]);
    }
    /**
     * Handle an users form.
     *
     * @throws ValidationException
     */
    public function storeUpdate(Request $request, $userId = 0): RedirectResponse
    {
           $request->validate([
               'name'          => 'required|string|max:255',
               'description'   => 'nullable|string|max:255',
               'is_active'     => 'required|integer|digits_between: 0,1',
               'parent_id'     => 'nullable|integer',
           ]);
           $storageFolder = 'blogCategories';
           if($request->hasFile('icon_file_path')){
               $file = $request->file('icon_file_path');
               $fileName =  Str::random(5).'__'.date('d_m_y_h_i_s').'.'.$file->getClientOriginalExtension();
               Storage::disk('public')->putFileAs($storageFolder, $file,$fileName);
               $fileNameWithPath = '/storage/'.$storageFolder.'/'.$fileName;
           }else{
               $fileNameWithPath = null;
           }
           BlogCategory::updateOrCreate([
               'name' => $request->get('name'),
               'slug' => Str::slug($request->get('name')),
           ],[
               'icon_file_path' => $fileNameWithPath,
               'description'    => $request->get('description'),
               'parent_id'      => $request->get('parent_id'),
               'is_active'      => $request->get('is_active'),
           ]);
           return redirect()->route('dashboard.be.blogCategories.list');
    }
    /**
     * Remove Book category
     * */
    public function remove($blog_category_id): RedirectResponse
    {
        BlogCategory::where('id',$blog_category_id)->delete();
        return redirect()->route('dashboard.be.blogCategories.list');
    }
    /**
     * Remove All Book category
     * */
    public function removeAll(): RedirectResponse
    {
        BlogCategory::query()->delete();
        return redirect()->route('dashboard.be.blogCategories.list');
    }
}
