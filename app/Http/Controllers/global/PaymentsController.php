<?php

namespace App\Http\Controllers\global;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaymentsController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        return Inertia::render('Pages/List', [
            'user' => $request->user(),
            'pageTitle' => 'Pages List',
        ]);
    }
}
