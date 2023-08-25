<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientApiController extends Controller
{

    public function sendResponse($data, $message, $status = 200): JsonResponse
    {
        $response = [
            'data' => $data,
            'message' => $message
        ];
        return response()->json($response, $status);
    }

    public function sendError($errorData, $message, $status = 500): JsonResponse
    {
        $response = [];
        $response['message'] = $message;
        if (!empty($errorData)) {
            $response['data'] = $errorData;
        }
        return response()->json($response, $status);
    }

    public function register(Request $request): JsonResponse
    {
        $input = $request->only('name', 'email', 'password', 'c_password');
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors(), 'Validation Error', 422);
        }
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['user'] = $user;
        return $this->sendResponse($success, 'user registered successfully', 201);

    }

    public function login(Request $request): JsonResponse
    {
        $input = $request->only('email', 'password');
        $validator = Validator::make($input, [
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors(), 'Validation Error', 422);
        }
        try {
            if (! $token = JWTAuth::attempt($input)) {
                return $this->sendError([], "invalid login credentials", 400);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
        $success = [
            'token' => $token,
        ];
        return $this->sendResponse($success, 'successful login', 200);
    }

    public function getUser(): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
        return $this->sendResponse($user, "user data retrieved", 200);
    }
    /**
     * List of books
     * */
    public function books(Request $request): JsonResponse
    {
        $sortFields         = ['id','title', 'slug', 'ISBN_10', 'ISBN_13', 'author', 'created_by', 'created_at', 'updated_at'];
        $PER_PAGE           = 8;
        $DEFAULT_SORT_FIELD = 'created_at';
        $DEFAULT_SORT_ORDER = 'desc';
        $sortFieldInput = $request->input('sort_field', $DEFAULT_SORT_FIELD);
        $sortField      = in_array($sortFieldInput, $sortFields) ? $sortFieldInput : $DEFAULT_SORT_ORDER;
        $sortOrder      = $request->input('sort_order', $DEFAULT_SORT_ORDER);
        $searchInput    = $request->input('search');
        $query          = Book::withCount('bookReviews')
                              ->withAvg('bookReviews', 'rating')
                              ->with('createdBy:id,name')
                              ->orderBy($sortField, $sortOrder);
        $perPage        = $request->input('per_page') ?? $PER_PAGE;
        if (!is_null($searchInput)) {
            $searchQuery = "%$searchInput%";
            $query       = $query->where('title', 'like', $searchQuery)
                ->orWhere('slug', 'like', $searchQuery)
                ->orWhere('ISBN_10', 'like', $searchQuery)
                ->orWhere('ISBN_13', 'like', $searchQuery)
                ->orWhere('author', 'like', $searchQuery);
        }
        return response()->json([
           'pageData'   => $query->paginate((int)$perPage)
        ]);
    }

    public function getSingleBookData($book_slug): JsonResponse
    {
        $book = Book::withCount('bookReviews')->withAvg('bookReviews', 'rating')->with('createdBy:id,name')->where('slug',$book_slug)->first();
        return response()->json([
           'pageData' => [
               'book' => $book,
               'bookReviews' => $book->bookReviews()->paginate(10)
           ]
        ]);
    }
}
