<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tip;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $latestTest = $user->latestSkinTest;
        $allTests = $user->skinTestResults()->orderByDesc('created_at')->take(10)->get();

        $products = collect();
        $tips = collect();

        if ($latestTest) {
            $products = Product::forSkinType($latestTest->skin_type)->take(6)->get();
            $tips = Tip::forSkinType($latestTest->skin_type)->take(4)->get();
        }

        return view('dashboard.index', compact('user', 'latestTest', 'allTests', 'products', 'tips'));
    }
}
