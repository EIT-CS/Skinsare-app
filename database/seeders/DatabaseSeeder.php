<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $hasIsAdmin = Schema::hasColumn('users', 'is_admin');
        $hasGender = Schema::hasColumn('users', 'gender');

        // Admin user
        $admin = [
            'name'     => 'Admin',
            'email'    => 'admin@skincare.mn',
            'password' => Hash::make('password123'),
        ];
        if ($hasIsAdmin) {
            $admin['is_admin'] = true;
        }
        if ($hasGender) {
            $admin['gender'] = 'female';
        }
        User::firstOrCreate(['email' => $admin['email']], $admin);

        // Test user
        $testUser = [
            'name'     => 'Test User',
            'email'    => 'test@skincare.mn',
            'password' => Hash::make('password123'),
        ];
        if ($hasGender) {
            $testUser['gender'] = 'female';
        }
        User::firstOrCreate(['email' => $testUser['email']], $testUser);

        $this->seedProducts();
        $this->seedTips();
    }

    private function seedProducts(): void
    {
        $products = [
            // Cleansers
            ['name' => 'CeraVe Hydrating Cleanser', 'category' => 'cleanser', 'price' => 45000, 'brand' => 'CeraVe', 'suitable_for' => ['dry', 'normal', 'sensitive'], 'description' => 'Хуурай болон мэдрэмтгий арьсанд тохирсон чийгшүүлэгч цэвэрлэгч. Керамид агуулсан.', 'rating' => 5],
            ['name' => 'La Roche-Posay Effaclar Gel', 'category' => 'cleanser', 'price' => 52000, 'brand' => 'La Roche-Posay', 'suitable_for' => ['oily', 'combination'], 'description' => 'Тослог арьсанд зориулсан гүн цэвэрлэгч гель. Нүхийг цэвэрлэж, тосны ялгаралтыг бууруулдаг.', 'rating' => 5],
            ['name' => 'Neutrogena Ultra Gentle Cleanser', 'category' => 'cleanser', 'price' => 38000, 'brand' => 'Neutrogena', 'suitable_for' => ['sensitive', 'normal', 'dry'], 'description' => 'Мэдрэмтгий арьсанд зориулсан маш зөөлөн цэвэрлэгч. Үнэргүй, спиртгүй.', 'rating' => 4],
            ['name' => 'Innisfree Volcanic Pore Cleansing Foam', 'category' => 'cleanser', 'price' => 35000, 'brand' => 'Innisfree', 'suitable_for' => ['oily', 'combination'], 'description' => 'Галт уулын чулуулгийн шингэний хүчтэй цэвэрлэгч хөөс.', 'rating' => 4],

            // Toners
            ['name' => 'COSRX AHA/BHA Clarifying Treatment Toner', 'category' => 'toner', 'price' => 42000, 'brand' => 'COSRX', 'suitable_for' => ['oily', 'combination'], 'description' => 'Батганы эсрэг AHA/BHA хүчил агуулсан тонер. Нүхийг нарийсгадаг.', 'rating' => 5],
            ['name' => 'Hada Labo Gokujyun Toner', 'category' => 'toner', 'price' => 48000, 'brand' => 'Hada Labo', 'suitable_for' => ['dry', 'normal', 'sensitive'], 'description' => '5 төрлийн гиалурон хүчил агуулсан гүнзгий чийгшүүлэгч тонер.', 'rating' => 5],
            ['name' => 'Klairs Supple Preparation Facial Toner', 'category' => 'toner', 'price' => 55000, 'brand' => 'Klairs', 'suitable_for' => ['sensitive', 'dry', 'combination'], 'description' => 'Мэдрэмтгий арьсанд тохирсон тайвшруулагч тонер. Спирт агуулдаггүй.', 'rating' => 5],

            // Moisturizers
            ['name' => 'Cetaphil Moisturizing Cream', 'category' => 'moisturizer', 'price' => 35000, 'brand' => 'Cetaphil', 'suitable_for' => ['dry', 'sensitive', 'normal'], 'description' => 'Хуурай, мэдрэмтгий арьсанд зориулсан гүн чийгшүүлэгч тос.', 'rating' => 4],
            ['name' => 'Neutrogena Hydro Boost Gel Cream', 'category' => 'moisturizer', 'price' => 58000, 'brand' => 'Neutrogena', 'suitable_for' => ['oily', 'combination', 'normal'], 'description' => 'Гиалурон хүчил агуулсан гель хэлбэрийн хөнгөн чийгшүүлэгч.', 'rating' => 5],
            ['name' => 'First Aid Beauty Ultra Repair Cream', 'category' => 'moisturizer', 'price' => 65000, 'brand' => 'FAB', 'suitable_for' => ['dry', 'sensitive'], 'description' => 'Маш хуурай, мэдрэмтгий арьсанд зориулсан эрчимт чийгшүүлэгч.', 'rating' => 5],
            ['name' => 'Belif The True Cream Moisturizing Bomb', 'category' => 'moisturizer', 'price' => 72000, 'brand' => 'Belif', 'suitable_for' => ['dry', 'combination'], 'description' => 'Цэцгийн ус агуулсан 26 цагийн чийгшүүлэгч тос.', 'rating' => 4],

            // Serums
            ['name' => 'The Ordinary Niacinamide 10% + Zinc 1%', 'category' => 'serum', 'price' => 28000, 'brand' => 'The Ordinary', 'suitable_for' => ['oily', 'combination'], 'description' => 'Нүхийг нарийсгаж, тосны ялгаралтыг бууруулдаг ниациnamид серум.', 'rating' => 5],
            ['name' => 'COSRX Advanced Snail 96 Mucin Power Essence', 'category' => 'serum', 'price' => 55000, 'brand' => 'COSRX', 'suitable_for' => ['dry', 'combination', 'normal'], 'description' => 'Улиас шулуусны мастикаар хийсэн арьс нөхөн сэргээгч серум.', 'rating' => 5],
            ['name' => 'Paula\'s Choice 2% BHA Liquid Exfoliant', 'category' => 'serum', 'price' => 68000, 'brand' => 'Paula\'s Choice', 'suitable_for' => ['oily', 'combination'], 'description' => 'Батга болон хар батгыг зайлуулдаг салицилийн хүчилт серум.', 'rating' => 5],

            // Sunscreens
            ['name' => 'Biore UV Aqua Rich Watery Essence SPF50+', 'category' => 'sunscreen', 'price' => 32000, 'brand' => 'Biore', 'suitable_for' => ['oily', 'combination', 'normal'], 'description' => 'Усархаг, хөнгөн нарнаас хамгааллах SPF50+ усны эссенс.', 'rating' => 5],
            ['name' => 'EltaMD UV Clear SPF46', 'category' => 'sunscreen', 'price' => 85000, 'brand' => 'EltaMD', 'suitable_for' => ['sensitive', 'oily', 'combination'], 'description' => 'Эмч нар зөвлөдөг мэдрэмтгий болон батгатай арьсанд зориулсан хамгааллах тос.', 'rating' => 5],

            // Spot treatments
            ['name' => 'Mario Badescu Drying Lotion', 'category' => 'spot', 'price' => 38000, 'brand' => 'Mario Badescu', 'suitable_for' => ['oily', 'combination'], 'description' => 'Шөнийн цагт батганы дээр нэмж хэрэглэдэг хатаагч лосьон.', 'rating' => 4],
            ['name' => 'COSRX Acne Pimple Master Patch', 'category' => 'spot', 'price' => 18000, 'brand' => 'COSRX', 'suitable_for' => ['oily', 'combination', 'dry', 'sensitive', 'normal'], 'description' => 'Батгыг шөнийн цагт хамгаалж, идийг шингэдэг гидроколлоид патч.', 'rating' => 5],

            // Masks
            ['name' => 'Aztec Secret Indian Healing Clay', 'category' => 'mask', 'price' => 25000, 'brand' => 'Aztec Secret', 'suitable_for' => ['oily', 'combination'], 'description' => 'Гүн цэвэрлэгч шавар маск. 100% кальцийн бентонит шавар.', 'rating' => 4],
            ['name' => 'Dr. Jart+ Cicapair Tiger Grass Mask', 'category' => 'mask', 'price' => 62000, 'brand' => 'Dr. Jart+', 'suitable_for' => ['sensitive', 'dry', 'combination'], 'description' => 'Тайгерграсс агуулсан тайвшруулагч, нөхөн сэргээгч маск.', 'rating' => 5],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }

    private function seedTips(): void
    {
        $tips = [
            // Morning routine
            ['title' => 'Өглөөний суурь арчилгаа', 'category' => 'morning_routine', 'icon' => '☀️', 'suitable_for' => ['dry', 'oily', 'combination', 'normal', 'sensitive'], 'content' => "Өглөө бүр эдгээр алхмуудыг дагана уу:\n\n1. **Цэвэрлэх** – Зөөлөн цэвэрлэгч ашиглан нүүрийг угаана\n2. **Тонер** – Арьсны pH-ийг тэнцвэржүүлнэ\n3. **Серум** – Тусгай асуудлыг шийдвэрлэнэ\n4. **Чийгшүүлэгч** – Арьсыг чийгжүүлнэ\n5. **Нарнаас хамгаалах** – SPF30+ хэрэглэнэ (заавал!)"],
            ['title' => 'Хуурай арьсны өглөөний арчилгаа', 'category' => 'morning_routine', 'icon' => '💧', 'suitable_for' => ['dry'], 'content' => "Хуурай арьсанд өглөө:\n\n• **Усаар угаах** – Угтал дахь гэм хор байхгүй болохоор зөвхөн цэвэр ус хэрэглэнэ\n• **Гиалурон хүчилт тонер** – Чийгийг хадгалах\n• **Тос баялаг чийгшүүлэгч** – Церамид, шэа бутер агуулсан\n• **Хамгаалах SPF** – Минерал эсвэл химийн"],
            ['title' => 'Тослог арьсны өглөөний арчилгаа', 'category' => 'morning_routine', 'icon' => '✨', 'suitable_for' => ['oily'], 'content' => "Тослог арьсанд өглөө:\n\n• **Цэвэрлэгч гель** – Гүн цэвэрлэх\n• **BHA/AHA тонер** – Нүхийг цэвэрлэх\n• **Хөнгөн серум** – Нианиамид эсвэл салицилийн хүчил\n• **Oil-free чийгшүүлэгч** – Гель хэлбэрийн\n• **Матлагч SPF** – Тос хаяхгүй"],

            // Evening routine
            ['title' => 'Оройн арчилгааны журам', 'category' => 'evening_routine', 'icon' => '🌙', 'suitable_for' => ['dry', 'oily', 'combination', 'normal', 'sensitive'], 'content' => "Шөнийн арчилгаа:\n\n1. **Double Cleanse** – Эхлээд тос цэвэрлэгч, дараа усан цэвэрлэгч\n2. **Эксфолиейт** – Долоо хоногт 2-3 удаа (AHA/BHA)\n3. **Тонер**\n4. **Идэвхит серум** – Ретинол, витамин C гэх мэт\n5. **Нүдний тос**\n6. **Чийгшүүлэгч эсвэл sleeping mask"],
            ['title' => 'Хуурай арьсны шөнийн арчилгаа', 'category' => 'evening_routine', 'icon' => '🌛', 'suitable_for' => ['dry', 'sensitive'], 'content' => "Хуурай арьсанд шөнөдөө:\n\n• **Тос үндэслэсэн цэвэрлэгч** – Арьсыг хатаахгүй\n• **Гиалурон хүчилт серум** – Норвог зөөлөн арьс дээр хэрэглэнэ\n• **Баялаг шөнийн крем** – Церамид, пептид агуулсан\n• **Sleeping mask** – Долоо хоногт 2 удаа"],

            // Acne treatment
            ['title' => 'Батгатай тэмцэх үндсэн зарчмууд', 'category' => 'acne_treatment', 'icon' => '🎯', 'suitable_for' => ['oily', 'combination'], 'content' => "Батгыг эмчлэх зарчмууд:\n\n• **Хүрэхгүй байх** – Хамгийн чухал дүрэм!\n• **Цэвэр гарт байх** – Нүүрэнд хүрэхдээ гараа угаана\n• **Эмийн идэвхит бодисууд ашиглах**:\n  - Бензоил пероксид (2.5-5%)\n  - Салицилийн хүчил (0.5-2%)\n  - Нианиамид (10%)\n  - Ретинол (0.025-0.1%)\n• **Нэгэн зэрэг маш олон бүтээгдэхүүн хэрэглэхгүй**"],
            ['title' => 'Хар батга (blackhead) зайлуулах', 'category' => 'acne_treatment', 'icon' => '⚫', 'suitable_for' => ['oily', 'combination'], 'content' => "Хар батга зайлуулах:\n\n• **BHA серум** – Салицилийн хүчил нүх дотор орж цэвэрлэдэг\n• **Clay mask** – Долоо хоногт 1-2 удаа хэрэглэнэ\n• **Нүх цэвэрлэгч тонер** – Spandex/witch hazel агуулсан\n• **Биеэр шахахгүй** – Сорви болон халдвар авч болно\n• **Нарийн зүүтэй хэрэгсэл** – Гоо сайхны эмчид хандах"],
            ['title' => 'Мэдрэмтгий арьсанд батга эмчлэх', 'category' => 'acne_treatment', 'icon' => '🌿', 'suitable_for' => ['sensitive'], 'content' => "Мэдрэмтгий арьсанд батга:\n\n• **Зөөлөн эмийн бодис** – Нианиамид (5-10%) - маш зөөлөн\n• **Азелаик хүчил** – Мэдрэмтгий арьсанд тохиромжтой\n• **Алоэ верагийн гель** – Тайвшруулах\n• **COSRX патч** – Батгыг хамгаалах\n• **Шинэ бүтээгдэхүүн туршихдаа** – Эхлээд бага хэмжээ хэрэглэж үз"],

            // Diet
            ['title' => 'Арьсанд ашигтай хоол', 'category' => 'diet', 'icon' => '🥗', 'suitable_for' => ['dry', 'oily', 'combination', 'normal', 'sensitive'], 'content' => "Арьсыг дотроос сайжруулах:\n\n**Ашигтай хоол:**\n• Загас (омега-3 тосны хүчил) – Тослог байдлыг зохицуулна\n• Улаан лооль – Ликопен агуулсан\n• Ногоон цай – Антиоксидант\n• Авокадо – Сайн тос агуулдаг\n• Шар лооль – Витамин C\n\n**Хязгаарлах хоол:**\n• Чихэр, амттан\n• Тосонд шарсан хоол\n• Сүүн бүтээгдэхүүн (хэрвээ арьс муудвал)\n• Кофе хэт их"],
            ['title' => 'Ус уух чухлыг ойлгох', 'category' => 'diet', 'icon' => '💦', 'suitable_for' => ['dry', 'oily', 'combination', 'normal', 'sensitive'], 'content' => "Арьс болон ус:\n\n• **Өдөрт 8-10 аяга ус уу** – Арьсыг дотроос чийгжүүлнэ\n• **Нимбэгтэй ус** – Хортой бодисыг цэвэрлэдэг\n• **Коллаген уухуй** – Арьсны уян хатан чанарыг нэмэгдүүлдэг\n• **Согтууруулах ундаа** – Арьсыг хатаадаг, хязгаарлана уу"],

            // Lifestyle
            ['title' => 'Дэр болон унтах дэглэм', 'category' => 'lifestyle', 'icon' => '😴', 'suitable_for' => ['dry', 'oily', 'combination', 'normal', 'sensitive'], 'content' => "Унтах болон арьс:\n\n• **Торгон дэрний бүрхүүл** – Хэвтэх үед батга болон мэдрэмтгий байдлыг бууруулдаг\n• **7-9 цаг унтах** – Арьс шөнөдөө нөхөн сэргэдэг\n• **Нүүрийг дэрэнд дарж унтахгүй байх** – Батга, үрчлээс үүсгэдэг\n• **Долоо хоногт нэг удаа дэр угаах** – Бактерийг арилгана"],
            ['title' => 'Стресс болон арьсны холбоо', 'category' => 'lifestyle', 'icon' => '🧘', 'suitable_for' => ['oily', 'combination', 'sensitive'], 'content' => "Стресс арьсанд нөлөөлдөг:\n\n• **Кортизол гормон** – Тосны ялгаралтыг нэмэгдүүлж, батга гаргадаг\n• **Медитаци** – Өдөрт 10 минут хийнэ\n• **Дасгал хөдөлгөөн** – Цусны эргэлтийг сайжруулдаг\n• **Амрах** – Хоббитой байх, хангалттай унтах\n• **Нийгмийн сүлжээ хязгаарлах** – Харьцуулах хүсэл бууруулна"],
        ];

        foreach ($tips as $t) {
            Tip::create($t);
        }
    }
}
