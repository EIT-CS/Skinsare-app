<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tip;
use App\Models\User;
use App\Models\SkinTestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users'    => User::count(),
            'tests'    => SkinTestResult::count(),
            'products' => Product::count(),
            'tips'     => Tip::count(),
        ];
        $recentUsers = User::orderByDesc('created_at')->take(5)->get();
        $skinStats   = SkinTestResult::selectRaw('skin_type, count(*) as total')
            ->groupBy('skin_type')->pluck('total', 'skin_type');

        return view('admin.dashboard', compact('stats', 'recentUsers', 'skinStats'));
    }

    // ===== Products CRUD =====
    public function products()
    {
        $products = Product::orderByDesc('created_at')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'category'     => 'required|string',
            'suitable_for' => 'required|array',
            'brand'        => 'nullable|string',
            'rating'       => 'nullable|integer|min:1|max:5',
            'image'        => 'nullable|image|max:2048',
            'image_url'    => 'nullable|url|max:4096',
            'is_active'    => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        unset($data['image_url']);
        $data['is_active'] = $request->has('is_active');
        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Бүтээгдэхүүн амжилттай нэмэгдлээ!');
    }

    public function editProduct(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'category'     => 'required|string',
            'suitable_for' => 'required|array',
            'brand'        => 'nullable|string',
            'rating'       => 'nullable|integer|min:1|max:5',
            'image'        => 'nullable|image|max:2048',
            'image_url'    => 'nullable|url|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && !str_starts_with($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            if ($product->image && !str_starts_with($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->input('image_url');
        }

        unset($data['image_url']);
        $data['is_active'] = $request->has('is_active');
        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Бүтээгдэхүүн шинэчлэгдлээ!');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image && !str_starts_with($product->image, 'http')) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Бүтээгдэхүүн устгагдлаа!');
    }

    // ===== Tips CRUD =====
    public function tips()
    {
        $tips = Tip::orderByDesc('created_at')->paginate(15);
        return view('admin.tips.index', compact('tips'));
    }

    public function createTip()
    {
        return view('admin.tips.create');
    }

    public function storeTip(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'category'     => 'required|string',
            'suitable_for' => 'required|array',
            'icon'         => 'nullable|string|max:10',
        ]);

        $data['is_active'] = $request->has('is_active');
        Tip::create($data);

        return redirect()->route('admin.tips')->with('success', 'Зөвлөгөө амжилттай нэмэгдлээ!');
    }

    public function editTip(Tip $tip)
    {
        return view('admin.tips.edit', compact('tip'));
    }

    public function updateTip(Request $request, Tip $tip)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'category'     => 'required|string',
            'suitable_for' => 'required|array',
            'icon'         => 'nullable|string|max:10',
        ]);

        $data['is_active'] = $request->has('is_active');
        $tip->update($data);

        return redirect()->route('admin.tips')->with('success', 'Зөвлөгөө шинэчлэгдлээ!');
    }

    public function deleteTip(Tip $tip)
    {
        $tip->delete();
        return redirect()->route('admin.tips')->with('success', 'Зөвлөгөө устгагдлаа!');
    }

    // ===== Users =====
    public function users()
    {
        $users = User::orderByDesc('created_at')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', 'Хэрэглэгчийн эрх шинэчлэгдлээ!');
    }
}
