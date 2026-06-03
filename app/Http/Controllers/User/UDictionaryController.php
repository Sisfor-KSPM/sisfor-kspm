<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class UDictionaryController extends Controller
{
    // ================= FUNGSI WEB (ADMIN) =================
    public function index(Request $request)
    {
        // [ANALYTICS] Track fitur kamus yang diakses user
        AnalyticsService::trackFeatureUsage('user_dictionary_page');
        
        // Fitur pencarian di sisi admin
        $search = $request->input('search');
        
        $terms = Dictionary::orderBy('istilah', 'asc')
            ->when($search, function ($query, $search) {
                return $query->where('istilah', 'like', "%{$search}%")
                             ->orWhere('definisi', 'like', "%{$search}%");
            })
            ->get();

        return view('user.kamus', compact('terms', 'search'));
    }

}