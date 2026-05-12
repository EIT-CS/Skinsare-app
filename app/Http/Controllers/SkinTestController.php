<?php

namespace App\Http\Controllers;

use App\Models\SkinTestResult;
use App\Models\Product;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkinTestController extends Controller
{
    private array $questions = [
        [
            'id'      => 1,
            'text'    => 'Нүүр угаасны дараа таны арьс ямархуу мэдрэгддэг вэ?',
            'options' => [
                ['label' => 'Татагдах, чангарах мэдрэмж', 'scores' => ['dry' => 3, 'oily' => 0, 'combination' => 1, 'sensitive' => 1]],
                ['label' => 'Хэвийн, тав тухтай', 'scores' => ['dry' => 0, 'oily' => 1, 'combination' => 1, 'sensitive' => 0]],
                ['label' => 'Бага зэрэг тосорхог', 'scores' => ['dry' => 0, 'oily' => 2, 'combination' => 2, 'sensitive' => 0]],
                ['label' => 'Маш тосорхог, гялтганасан', 'scores' => ['dry' => 0, 'oily' => 3, 'combination' => 1, 'sensitive' => 0]],
            ],
        ],
        [
            'id'      => 2,
            'text'    => 'Нүүрний ямар хэсэгт хамгийн ихээр тос гардаг вэ?',
            'options' => [
                ['label' => 'Огт гардаггүй, нүүр маань хуурайдаг', 'scores' => ['dry' => 3, 'oily' => 0, 'combination' => 0, 'sensitive' => 1]],
                ['label' => 'Бүхэлд нь жигд', 'scores' => ['dry' => 0, 'oily' => 3, 'combination' => 0, 'sensitive' => 0]],
                ['label' => 'Голдуу T-бүс (духан, хамар, эрүү)', 'scores' => ['dry' => 0, 'oily' => 1, 'combination' => 3, 'sensitive' => 0]],
                ['label' => 'Хацар дээр', 'scores' => ['dry' => 1, 'oily' => 2, 'combination' => 1, 'sensitive' => 0]],
            ],
        ],
        [
            'id'      => 3,
            'text'    => 'Батга хэр зэрэг гардаг вэ?',
            'options' => [
                ['label' => 'Огт гардаггүй', 'scores' => ['dry' => 1, 'oily' => 0, 'combination' => 0, 'sensitive' => 0]],
                ['label' => 'Маш цөөхөн, ховор', 'scores' => ['dry' => 1, 'oily' => 0, 'combination' => 1, 'sensitive' => 1]],
                ['label' => 'Заримдаа, ялангуяа T-бүсэнд', 'scores' => ['dry' => 0, 'oily' => 1, 'combination' => 3, 'sensitive' => 0]],
                ['label' => 'Байнга, олон газар', 'scores' => ['dry' => 0, 'oily' => 3, 'combination' => 1, 'sensitive' => 1]],
            ],
        ],
        [
            'id'      => 4,
            'text'    => 'Нүүрний нүх (пор) харагдах уу?',
            'options' => [
                ['label' => 'Харагддаггүй, нарийн', 'scores' => ['dry' => 2, 'oily' => 0, 'combination' => 0, 'sensitive' => 1]],
                ['label' => 'Бага зэрэг харагддаг', 'scores' => ['dry' => 0, 'oily' => 1, 'combination' => 2, 'sensitive' => 0]],
                ['label' => 'Хамар, духандаа том харагддаг', 'scores' => ['dry' => 0, 'oily' => 1, 'combination' => 3, 'sensitive' => 0]],
                ['label' => 'Бүх газар том харагддаг', 'scores' => ['dry' => 0, 'oily' => 3, 'combination' => 1, 'sensitive' => 0]],
            ],
        ],
        [
            'id'      => 5,
            'text'    => 'Шинэ бүтээгдэхүүн хэрэглэхэд арьс ямар хариу үйлдэл үзүүлдэг вэ?',
            'options' => [
                ['label' => 'Ямар ч хариу үзүүлдэггүй, зөөлрүүлдэг', 'scores' => ['dry' => 1, 'oily' => 0, 'combination' => 1, 'sensitive' => 0]],
                ['label' => 'Заримдаа улаарч, тосолгоо мэдрэгддэг', 'scores' => ['dry' => 0, 'oily' => 2, 'combination' => 1, 'sensitive' => 0]],
                ['label' => 'Хурдан улаарч, загатнадаг', 'scores' => ['dry' => 1, 'oily' => 0, 'combination' => 0, 'sensitive' => 3]],
                ['label' => 'Өт хальслах, хатах', 'scores' => ['dry' => 3, 'oily' => 0, 'combination' => 0, 'sensitive' => 1]],
            ],
        ],
        [
            'id'      => 6,
            'text'    => 'Өдрийн дундуур нүүрний арьс ямар харагддаг вэ?',
            'options' => [
                ['label' => 'Хуурай, хальслах шинж', 'scores' => ['dry' => 3, 'oily' => 0, 'combination' => 0, 'sensitive' => 1]],
                ['label' => 'Хэвийн харагддаг', 'scores' => ['dry' => 1, 'oily' => 0, 'combination' => 1, 'sensitive' => 0]],
                ['label' => 'Бага зэрэг гялтганасан', 'scores' => ['dry' => 0, 'oily' => 1, 'combination' => 2, 'sensitive' => 0]],
                ['label' => 'Маш тосорхог, гялтганасан', 'scores' => ['dry' => 0, 'oily' => 3, 'combination' => 1, 'sensitive' => 0]],
            ],
        ],
        [
            'id'      => 7,
            'text'    => 'Арьсны уян хатан байдал ямар байдаг вэ?',
            'options' => [
                ['label' => 'Маш уян, зөөлөн', 'scores' => ['dry' => 0, 'oily' => 1, 'combination' => 1, 'sensitive' => 0]],
                ['label' => 'Хэвийн', 'scores' => ['dry' => 1, 'oily' => 1, 'combination' => 2, 'sensitive' => 0]],
                ['label' => 'Бага зэрэг хатуу, татагдсан мэт', 'scores' => ['dry' => 2, 'oily' => 0, 'combination' => 1, 'sensitive' => 1]],
                ['label' => 'Маш хатуу, хальслах шинж', 'scores' => ['dry' => 3, 'oily' => 0, 'combination' => 0, 'sensitive' => 2]],
            ],
        ],
        [
            'id'      => 8,
            'text'    => 'Нарны гэрэлд арьс хэрхэн хариу үйлдэл үзүүлдэг вэ?',
            'options' => [
                ['label' => 'Хурдан хар болдог', 'scores' => ['dry' => 0, 'oily' => 1, 'combination' => 1, 'sensitive' => 0]],
                ['label' => 'Аажим шатдаг, хар болдог', 'scores' => ['dry' => 1, 'oily' => 1, 'combination' => 1, 'sensitive' => 0]],
                ['label' => 'Хурдан улаарч, шатдаг', 'scores' => ['dry' => 1, 'oily' => 0, 'combination' => 0, 'sensitive' => 3]],
                ['label' => 'Нарт гэрэлд тосорхог харагддаг', 'scores' => ['dry' => 0, 'oily' => 2, 'combination' => 1, 'sensitive' => 0]],
            ],
        ],
    ];

    public function show()
    {
        return view('test.index', ['questions' => $this->questions]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $scores = ['dry' => 0, 'oily' => 0, 'combination' => 0, 'sensitive' => 0];
        $answers = $request->answers;

        foreach ($this->questions as $question) {
            $qId = $question['id'];
            if (isset($answers[$qId])) {
                $optionIndex = (int) $answers[$qId];
                if (isset($question['options'][$optionIndex])) {
                    foreach ($question['options'][$optionIndex]['scores'] as $type => $score) {
                        $scores[$type] += $score;
                    }
                }
            }
        }

        // Determine skin type
        arsort($scores);
        $dominantType = array_key_first($scores);

        // Check for normal skin (balanced scores)
        $maxScore = max($scores);
        $minScore = min($scores);
        if (($maxScore - $minScore) <= 3) {
            $dominantType = 'normal';
        }

        $result = null;
        if (Auth::check()) {
            $result = SkinTestResult::create([
                'user_id'           => Auth::id(),
                'skin_type'         => $dominantType,
                'answers'           => $answers,
                'score_dry'         => $scores['dry'],
                'score_oily'        => $scores['oily'],
                'score_combination' => $scores['combination'],
                'score_sensitive'   => $scores['sensitive'],
            ]);
        }

        $products = Product::forSkinType($dominantType)->take(6)->get();
        $tips     = Tip::forSkinType($dominantType)->take(4)->get();

        return view('test.result', compact('dominantType', 'scores', 'products', 'tips', 'result'));
    }
}