<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        try {
            return Inertia::render('global/Users/List', [
                'user' => $request->user(),
                'pageTitle' => 'Users List',
                'pageDescription' => 'A list of all the users in your account including their name, title, email and role.',
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }
    /**
     * User Create Form
     */
    public function create(Request $request): Response
    {
        try {
            return Inertia::render('global/Users/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Create User',
                'pageDescription' => '',
                'pageData' => null,
                'rolesList' => Role::where('slug','!=','admin')->get(),
                'formUrl' => route('dashboard.global.users.storeUpdate')
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }

    /**
     * User Create Form
     */
    public function edit($userId , Request $request): Response
    {
        try {
            $getUserInfo = User::with(['roles'])->where('id',$userId)->first();
            return Inertia::render('global/Users/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Edit User',
                'pageDescription' => '',
                'pageData' => $getUserInfo,
                'rolesList' => Role::where('slug','!=','admin')->get(),
                'formUrl' => route('dashboard.global.users.storeUpdate',$userId)
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
    public function storeUpdate(Request $request, $userId = 0): RedirectResponse
    {
        $required = $userId === 0 ? 'required | confirmed' : '';
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|'.Rule::unique(User::class)->ignore($userId),
            'password' => $required,
        ]);
        $user = User::updateOrCreate([
            'email' => $request->email,
        ],[
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles([$request->get('roles')]);
        return redirect()->route('dashboard.global.users.list');
    }
    /**
     * Remove User
     * */
    public function remove($user_id){
        User::where('id',$user_id)->delete();
        return redirect()->route('dashboard.global.users.list');
    }
}
