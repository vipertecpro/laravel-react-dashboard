<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        try {
            return Inertia::render('global/Roles/List', [
                'user' => $request->user(),
                'pageTitle' => 'Roles List',
                'pageDescription' => 'A list of all the permissions.'
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
            return Inertia::render('global/Roles/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Create Role',
                'pageDescription' => '',
                'pageData' => null,
                'formUrl' => route('dashboard.global.roles.storeUpdate')
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }

    /**
     * Role Create Form
     */
    public function edit($roleId , Request $request): Response
    {
        try {
            $getRoleInfo = Role::where('id',$roleId)->first();
            return Inertia::render('global/Roles/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Edit Role',
                'pageDescription' => '',
                'pageData' => $getRoleInfo,
                'formUrl' => route('dashboard.global.roles.storeUpdate',$roleId)
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
        $request->validate([
            'name'          => 'required|string|max:255',
            'slug'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:255',
            'is_active'     => 'required|integer|min:1|digits_between: 0,1',
            'guard_name'    => 'required|string|max:255',
            'user_type'     => 'required|string|max:255',
            'record_access' => 'required|string|max:255',
        ]);
        Role::updateOrCreate([
            'name' => $request->name,
        ],[
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'guard_name' => $request->guard_name,
            'user_type' => $request->user_type,
            'record_access' => $request->record_access,
        ]);
        return redirect()->route('dashboard.global.roles.list');
    }
    /**
     * Remove Role
     * */
    public function remove($role_id){
        Role::where('id',$role_id)->delete();
        return redirect()->route('dashboard.global.roles.list');
    }
}
