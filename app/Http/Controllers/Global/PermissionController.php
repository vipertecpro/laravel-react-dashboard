<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        try {
            return Inertia::render('global/Permissions/List', [
                'user' => $request->user(),
                'pageTitle' => 'Permissions List',
                'pageDescription' => 'A list of all the permissions.'
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }
    /**
     * Permission Create Form
     */
    public function create(Request $request): Response
    {
        try {
            return Inertia::render('global/Permissions/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Create Permission',
                'pageDescription' => '',
                'pageData' => null,
                'formUrl' => route('dashboard.global.permissions.storeUpdate')
            ]);
        }catch (Exception $exception){
            dd($exception);
        }
    }

    /**
     * Permission Create Form
     */
    public function edit($permissionId , Request $request): Response
    {
        try {
            $getPermissionInfo = Permission::with(['roles'])->where('id',$permissionId)->first();
            return Inertia::render('global/Permissions/Form', [
                'user' => $request->user(),
                'pageTitle' => 'Edit Permission',
                'pageDescription' => '',
                'pageData' => $getPermissionInfo,
                'formUrl' => route('dashboard.global.permissions.storeUpdate',$permissionId)
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
        ]);

        Permission::updateOrCreate([
            'name' => $request->name,
        ],[
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'guard_name' => $request->guard_name,
        ]);
        return redirect()->route('dashboard.global.permissions.list');
    }
    /**
     * Remove Permission
     * */
    public function remove($permission_id){
        Permission::where('id',$permission_id)->delete();
        return redirect()->route('dashboard.global.permissions.list');
    }
}
