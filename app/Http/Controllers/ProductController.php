<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Tip;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $skinType = $request->get('skin_type');
        $category = $request->get('category');

        $query = Product::active();

        if ($skinType) {
            $query->forSkinType($skinType);
        }

        if ($category) {
            $query->where('category', $category);
        }

        $products = $query->orderByDesc('rating')->paginate(12);

        $categories = [
            'cleanser',
            'toner',
            'moisturizer',
            'serum',
            'sunscreen',
            'mask',
            'spot',
            'eye_cream',
        ];

        return view('products.index', compact('products', 'categories', 'skinType', 'category'));
    }

    public function tips(Request $request)
    {
        $skinType = $request->get('skin_type');

        $query = Tip::active();

        if ($skinType) {
            $query->forSkinType($skinType);
        }

        $tips      = $query->get();
        $acneTypes = $this->getAcneTypes();

        return view('products.tips', compact('tips', 'skinType', 'acneTypes'));
    }

    private function getAcneTypes(): array
    {
        return [
            [
                'name'        => 'Цагаан батга (Whitehead)',
                'icon'        => '⚪',
                'description' => 'Арьсны гадаргуугийн доор хаагдсан нүх. Цагаан эсвэл шаргал цэгүүд харагддаг. Гарт хүрэхгүй байх нь чухал.',
                'causes'      => 'Арьсны тос, үхсэн эс, бактерийн хуримтлал',
                'treatment'   => 'Зөөлөн цэвэрлэгч, салицилийн хүчил (BHA)',
                'color'       => '#8a8a6a',
            ],
            [
                'name'        => 'Хар батга (Blackhead)',
                'icon'        => '⚫',
                'description' => 'Нээлттэй нүхэнд хаагдсан тос. Агаарт өртөж хар өнгөтэй болдог. Хамгийн түгээмэл батгын нэг.',
                'causes'      => 'Арьсны тос, нүхний томрол, үхсэн эс',
                'treatment'   => 'BHA тонер, шавар маск, нүх цэвэрлэгч серум',
                'color'       => '#3a3a3a',
            ],
            [
                'name'        => 'Папула батга',
                'icon'        => '🔴',
                'description' => 'Улаан, өвдөлттэй, идэгдэхгүй батга. Арьс доорх үрэвслийн шинж тэмдэг. Шахаж болохгүй.',
                'causes'      => 'Бактерийн халдвар, дархлааны хариу үйлдэл',
                'treatment'   => 'Бензоил пероксид, нианиамид серум',
                'color'       => '#e74c3c',
            ],
            [
                'name'        => 'Пустул батга',
                'icon'        => '🟡',
                'description' => 'Ид дүүрсэн, улаан захтай батга. Шар эсвэл цагаан оройтой. Хөндөхгүй байх нь зайлшгүй.',
                'causes'      => 'Бактери, дархлааны хариу үйлдэл, тосны хаагдал',
                'treatment'   => 'Гидроколлоид патч, эмчийн зөвлөгөө',
                'color'       => '#f39c12',
            ],
            [
                'name'        => 'Нодул батга',
                'icon'        => '🔵',
                'description' => 'Гүн, том, хатуу батга. Маш өвдөлттэй бөгөөд сорви үлдээдэг. Заавал эмчид хандах шаардлагатай.',
                'causes'      => 'Гүн үрэвсэл, дааврын тэнцвэргүй байдал',
                'treatment'   => 'Эмчийн жор зайлшгүй шаардлагатай',
                'color'       => '#2980b9',
            ],
            [
                'name'        => 'Кистозна батга',
                'icon'        => '🟣',
                'description' => 'Хамгийн хүнд хэлбэрийн батга. Шингэн дүүрсэн том цист. Ноцтой сорви үлдээх эрсдэлтэй.',
                'causes'      => 'Дааврын тэнцвэргүй байдал, генетик хүчин зүйл',
                'treatment'   => 'Заавал арьс судлаачид хандах, изотретиноин',
                'color'       => '#8e44ad',
            ],
        ];
    }
}
