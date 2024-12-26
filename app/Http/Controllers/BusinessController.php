<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function show($id, $slug)
    {
        $business = Business::findOrFail($id);

        // Redirect to slug-only URL if slug doesn't match
        if ($business->slug !== $slug) {
            return redirect()->route('business.show', ['slug' => $business->slug]);
        }

        return view('business.show', compact('business'));
    }

}
