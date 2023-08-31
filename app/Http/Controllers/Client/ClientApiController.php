<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 'Validation Error', 422);
        }
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['user'] = $user;
        return $this->sendResponse($success, 'user registered successfully', 201);

    }
    /**
     * Ensure the login request is not rate limited.
     *
     */
    public function ensureIsNotRateLimited(Request $request): bool|array
    {
        $checkRateLimiter = RateLimiter::tooManyAttempts($this->throttleKey($request), 5);
        if ($checkRateLimiter) {
            event(new Lockout($request));
            return [
                'seconds' => RateLimiter::availableIn($this->throttleKey($request))
            ];
        }
        return false;
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->get('email')).'|'.$request->ip());
    }
    /**
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $input = $request->only('email', 'password');
            $validator = Validator::make($input, [
                'email' => 'required',
                'password' => 'required',
            ]);
            if($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => "Validation Error"
                ], 422);
            }
            $getRateLimiterResponse = $this->ensureIsNotRateLimited($request);
            if($getRateLimiterResponse !== false){
                return response()->json([
                    'errors' => [],
                    'message' => "Too Many Attempts, try after ".ceil($getRateLimiterResponse['seconds'] / 60)." minutes ".$getRateLimiterResponse['seconds']." seconds"
                ], 422);
            }
            if (!$token = JWTAuth::attempt($request->only('email', 'password'), $request->get('remember'))) {
                RateLimiter::hit($this->throttleKey($request));
                return response()->json([
                    'errors' => [],
                    'message' => "Invalid Login Credentials"
                ], 422);
            }
            RateLimiter::clear($this->throttleKey($request));
        } catch (JWTException $e) {
            return response()->json([
                'errors' => [],
                'message' => $e->getMessage()
            ], 422);
        }
        return response()->json([
            'errors' => [],
            'token' => $token,
            'message' => 'Logged In Successfully',
            'redirectUrl' => '/dashboard'
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            JWTAuth::parseToken()->invalidate( true );
            return response()->json( [
                'error'   => [],
                'message' => 'Logged out successfully'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'errors' => [],
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function getUser(): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json([
                    'error'    => [],
                    'message'  => "user not found",
                    'user'     => null
                ],422);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error'    => [],
                'message'  => $e->getMessage(),
                'user'     => null
            ],422);
        }
        return response()->json([
            'message' => "user data retrieved",
            'user'    => $user
        ]);
    }
    /**
     *
     * */
    public function getJwtToken(Request $request): Response|JsonResponse
    {
        if ($request->expectsJson()) {
            return new JsonResponse(null, 204);
        }

        return new Response('', 204);
    }

    /**
     * List of books
     * */
    public function books(Request $request): JsonResponse
    {
        $sortFields = ['id', 'title', 'slug', 'ISBN_10', 'ISBN_13', 'author', 'created_by', 'created_at', 'updated_at'];
        $PER_PAGE = 8;
        $DEFAULT_SORT_FIELD = 'created_at';
        $DEFAULT_SORT_ORDER = 'desc';
        $sortFieldInput = $request->input('sort_field', $DEFAULT_SORT_FIELD);
        $sortField = in_array($sortFieldInput, $sortFields) ? $sortFieldInput : $DEFAULT_SORT_ORDER;
        $sortOrder = $request->input('sort_order', $DEFAULT_SORT_ORDER);
        $searchInput = $request->input('search');
        $query = Book::withCount('bookReviews')
            ->withAvg('bookReviews', 'rating')
            ->with('createdBy:id,name')
            ->orderBy($sortField, $sortOrder);
        $perPage = $request->input('per_page') ?? $PER_PAGE;
        if (!is_null($searchInput)) {
            $searchQuery = "%$searchInput%";
            $query = $query->where('title', 'like', $searchQuery)
                ->orWhere('slug', 'like', $searchQuery)
                ->orWhere('ISBN_10', 'like', $searchQuery)
                ->orWhere('ISBN_13', 'like', $searchQuery)
                ->orWhere('author', 'like', $searchQuery);
        }
        return response()->json([
            'pageData' => $query->paginate((int)$perPage)
        ]);
    }

    public function getSingleBookData($book_slug): JsonResponse
    {
        $book = Book::withCount('bookReviews')->withAvg('bookReviews', 'rating')->with('createdBy:id,name')->where('slug', $book_slug)->first();
        return response()->json([
            'pageData' => [
                'book' => $book,
                'bookReviews' => $book->bookReviews()->paginate(10)
            ]
        ]);
    }
}
