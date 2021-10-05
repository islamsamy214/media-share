<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('index');
    } //end of index

    public function visit(Request $request)
    {
        $visitor = Visit::firstOrCreate(
            ['ip' => $request->ip()],
            ['visits_count' => 0]
        );

        $visitor->update(['visits_count' => $visitor->visits_count + 1]);
    } //end of visit
}
