<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookReviewResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Book;
use App\Models\BookReview;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiController extends Controller
{

    /**
     * Display the user's list.
     */
    public function users(Request $request): AnonymousResourceCollection
    {
        $sortFields         = ['id','name', 'address', 'email', 'created_at', 'updated_at'];
        $PER_PAGE           = 10;
        $DEFAULT_SORT_FIELD = 'created_at';
        $DEFAULT_SORT_ORDER = 'asc';
        $sortFieldInput = $request->input('sort_field', $DEFAULT_SORT_FIELD);
        $sortField      = in_array($sortFieldInput, $sortFields) ? $sortFieldInput : $DEFAULT_SORT_ORDER;
        $sortOrder      = $request->input('sort_order', $DEFAULT_SORT_ORDER);
        $searchInput    = $request->input('search');
        $query          = User::with(['roles'])->orderBy($sortField, $sortOrder);
        $perPage        = $request->input('per_page') ?? $PER_PAGE;
        if (!is_null($searchInput)) {
            $searchQuery = "%$searchInput%";
            $query       = $query->where('name', 'like', $searchQuery)
                ->orWhere('email', 'like', $searchQuery)
                ->orWhereHas('roles',function($query) use ($searchQuery){
                    $query->where('name',$searchQuery);
                });
        }
        return UserResource::collection($query->paginate((int)$perPage));
    }
    /**
     * Display the permissions list.
     */
    public function permissions(Request $request): AnonymousResourceCollection
    {
        $sortFields         = ['id','name', 'slug', 'description', 'is_active', 'guard_name', 'created_at', 'updated_at'];
        $PER_PAGE           = 10;
        $DEFAULT_SORT_FIELD = 'created_at';
        $DEFAULT_SORT_ORDER = 'asc';
        $sortFieldInput = $request->input('sort_field', $DEFAULT_SORT_FIELD);
        $sortField      = in_array($sortFieldInput, $sortFields) ? $sortFieldInput : $DEFAULT_SORT_ORDER;
        $sortOrder      = $request->input('sort_order', $DEFAULT_SORT_ORDER);
        $searchInput    = $request->input('search');
        $query          = Permission::orderBy($sortField, $sortOrder);
        $perPage        = $request->input('per_page') ?? $PER_PAGE;
        if (!is_null($searchInput)) {
            $searchQuery = "%$searchInput%";
            $query       = $query->where('name', 'like', $searchQuery)
                ->orWhere('slug', 'like', $searchQuery)
                ->orWhere('description', 'like', $searchQuery)
                ->orWhere('guard_name', 'like', $searchQuery)
                ->orWhere('is_active', 'like', $searchQuery);
        }
        return PermissionResource::collection($query->paginate((int)$perPage));
    }
    /**
     * Display the roles list.
     */
    public function roles(Request $request): AnonymousResourceCollection
    {
        $sortFields         = ['id','name', 'slug', 'description', 'is_active', 'guard_name', 'user_type', 'record_access', 'created_at', 'updated_at'];
        $PER_PAGE           = 10;
        $DEFAULT_SORT_FIELD = 'created_at';
        $DEFAULT_SORT_ORDER = 'asc';
        $sortFieldInput = $request->input('sort_field', $DEFAULT_SORT_FIELD);
        $sortField      = in_array($sortFieldInput, $sortFields) ? $sortFieldInput : $DEFAULT_SORT_ORDER;
        $sortOrder      = $request->input('sort_order', $DEFAULT_SORT_ORDER);
        $searchInput    = $request->input('search');
        $query          = Role::orderBy($sortField, $sortOrder);
        $perPage        = $request->input('per_page') ?? $PER_PAGE;
        if (!is_null($searchInput)) {
            $searchQuery = "%$searchInput%";
            $query       = $query->where('name', 'like', $searchQuery)
                                ->orWhere('slug', 'like', $searchQuery)
                                ->orWhere('description', 'like', $searchQuery)
                                ->orWhere('guard_name', 'like', $searchQuery)
                                ->orWhere('is_active', 'like', $searchQuery);
        }
        return RoleResource::collection($query->paginate((int)$perPage));
    }
    /**
     * Display the books list.
     */
    public function books(Request $request): AnonymousResourceCollection
    {
        $sortFields         = ['id','title', 'slug', 'ISBN_10', 'ISBN_13', 'author', 'created_by', 'created_at', 'updated_at'];
        $PER_PAGE           = 10;
        $DEFAULT_SORT_FIELD = 'created_at';
        $DEFAULT_SORT_ORDER = 'desc';
        $sortFieldInput = $request->input('sort_field', $DEFAULT_SORT_FIELD);
        $sortField      = in_array($sortFieldInput, $sortFields) ? $sortFieldInput : $DEFAULT_SORT_ORDER;
        $sortOrder      = $request->input('sort_order', $DEFAULT_SORT_ORDER);
        $searchInput    = $request->input('search');
        $query          = Book::orderBy($sortField, $sortOrder);
        $perPage        = $request->input('per_page') ?? $PER_PAGE;
        if (!is_null($searchInput)) {
            $searchQuery = "%$searchInput%";
            $query       = $query->where('title', 'like', $searchQuery)
                ->orWhere('slug', 'like', $searchQuery)
                ->orWhere('ISBN_10', 'like', $searchQuery)
                ->orWhere('ISBN_13', 'like', $searchQuery)
                ->orWhere('author', 'like', $searchQuery);
        }
        return BookResource::collection($query->paginate((int)$perPage));
    }
    /**
     * Display the book reviews list.
     */
    public function bookReviews(Request $request): AnonymousResourceCollection
    {
        $sortFields         = ['id','content', 'rating', 'status', 'book_id','created_by', 'created_at', 'updated_at'];
        $PER_PAGE           = 10;
        $DEFAULT_SORT_FIELD = 'created_at';
        $DEFAULT_SORT_ORDER = 'desc';
        $sortFieldInput = $request->input('sort_field', $DEFAULT_SORT_FIELD);
        $sortField      = in_array($sortFieldInput, $sortFields) ? $sortFieldInput : $DEFAULT_SORT_ORDER;
        $sortOrder      = $request->input('sort_order', $DEFAULT_SORT_ORDER);
        $searchInput    = $request->input('search');
        $query          = BookReview::orderBy($sortField, $sortOrder);
        $perPage        = $request->input('per_page') ?? $PER_PAGE;
        if (!is_null($searchInput)) {
            $searchQuery = "%$searchInput%";
            $query       = $query->where('title', 'like', $searchQuery)
                ->orWhere('slug', 'like', $searchQuery)
                ->orWhere('ISBN_10', 'like', $searchQuery)
                ->orWhere('ISBN_13', 'like', $searchQuery)
                ->orWhere('author', 'like', $searchQuery);
        }
        return BookReviewResource::collection($query->paginate((int)$perPage));
    }

}
