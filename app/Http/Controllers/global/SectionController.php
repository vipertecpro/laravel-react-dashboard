<?php

namespace App\Http\Controllers\global;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SectionController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        return Inertia::render('Sections/List', [
            'user' => $request->user(),
            'pageTitle' => 'Sections List',
        ]);
    }
}
