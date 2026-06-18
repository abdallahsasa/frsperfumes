<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Note;
use App\Models\Accord;
use App\Models\Perfume;
use App\Models\PerfumeImage;
use App\Models\Banner;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@frsperfumes.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Create Settings
        Setting::setValue('contact_email', 'admin@frsperfumes.com', 'email');
        Setting::setValue('whatsapp_number', '966500000000', 'tel'); // Saudi Number format
        Setting::setValue('shipping_fee', '15', 'text');
        
        // Translatable Settings
        Setting::setValue('site_title_en', 'FRS Perfumes | Premium Luxury Fragrances', 'text');
        Setting::setValue('site_title_ar', 'إف آر إس للعطور | عطور فاخرة مميزة', 'text');
        
        Setting::setValue('brand_story_en', 'FRS Perfumes brings you the finest selection of premium niche and designer fragrances, curated for the modern connoisseur. Experience olfactory perfection.', 'textarea');
        Setting::setValue('brand_story_ar', 'تقدم لك عطور إف آر إس أرقى التشكيلات من العطور النيش والمصممة الفاخرة، المختارة بعناية لعشاق العطور العصريين. جرب الكمال العطري بنفسك.', 'textarea');

        // 3. Create Banners
        Banner::updateOrCreate(
            ['image_path' => 'banners/banner1.jpg'],
            [
                'title_en' => 'Discover Your Signature Scent',
                'title_ar' => 'اكتشف عطرك المميز',
                'subtitle_en' => 'Explore the finest luxury perfumes in the world.',
                'subtitle_ar' => 'استكشف أرقى العطور الفاخرة في العالم.',
                'link_url' => '/shop',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['image_path' => 'banners/banner2.jpg'],
            [
                'title_en' => 'The Golden Guarantee',
                'title_ar' => 'الضمان الذهبي',
                'subtitle_en' => 'Try a 1ml tester first. Don\'t like the scent? Return the perfume for free.',
                'subtitle_ar' => 'جرب عينة 1 مل أولاً. لم يعجبك العطر؟ أعد الزجاجة مجاناً.',
                'link_url' => '/shop',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        // 4. Create Brands
        $creed = Brand::updateOrCreate(['slug' => 'creed'], [
            'name_en' => 'Creed', 
            'name_ar' => 'كريد', 
            'description_en' => 'Established in 1760, Creed is an ancient Parisian perfume house known for its luxurious fragrances.', 
            'description_ar' => 'تأسست دار كريد عام 1760، وهي دار عطور باريسية عريقة تشتهر بعطورها الفاخرة.', 
            'is_active' => true
        ]);
        $dior = Brand::updateOrCreate(['slug' => 'dior'], [
            'name_en' => 'Dior', 
            'name_ar' => 'ديور', 
            'description_en' => 'Christian Dior was a French fashion designer, best known as the founder of one of the world\'s top fashion houses.', 
            'description_ar' => 'ديور هي دار أزياء وعطور فرنسية فاخرة شهيرة تأسست على يد كريستيان ديور.', 
            'is_active' => true
        ]);
        $chanel = Brand::updateOrCreate(['slug' => 'chanel'], [
            'name_en' => 'Chanel', 
            'name_ar' => 'شانيل', 
            'description_en' => 'Chanel is a French luxury fashion house that was founded in 1910 by Coco Chanel.', 
            'description_ar' => 'شانيل هي دار أزياء وعطور فرنسية فاخرة تأسست عام 1910 على يد كوكو شانيل.', 
            'is_active' => true
        ]);
        $mfk = Brand::updateOrCreate(['slug' => 'maison-francis-kurkdjian'], [
            'name_en' => 'Maison Francis Kurkdjian', 
            'name_ar' => 'ميسون فرانسيس كوركدجيان', 
            'description_en' => 'A luxury fragrance house co-founded by master perfumer Francis Kurkdjian.', 
            'description_ar' => 'دار عطور فاخرة شارك في تأسيسها خبير العطور الشهير فرانسيس كوركدجيان.', 
            'is_active' => true
        ]);

        // 5. Create Notes
        $notesData = [
            'Pineapple' => ['name_ar' => 'أناناس', 'image' => 'pineapple.jpg'],
            'Bergamot' => ['name_ar' => 'برغموت', 'image' => 'bergamot.jpg'],
            'Birch' => ['name_ar' => 'خشب البتولا', 'image' => 'birch.jpg'],
            'Patchouli' => ['name_ar' => 'باتشولي', 'image' => 'patchouli.jpg'],
            'Jasmine' => ['name_ar' => 'ياسمين', 'image' => 'jasmine.jpg'],
            'Ambergris' => ['name_ar' => 'عنبر الحوت', 'image' => 'ambergris.jpg'],
            'Musk' => ['name_ar' => 'مسك', 'image' => 'musk.jpg'],
            'Oakmoss' => ['name_ar' => 'طحلب البلوط', 'image' => 'oakmoss.jpg'],
            'Vanilla' => ['name_ar' => 'فانيليا', 'image' => 'vanilla.jpg'],
            'Lavender' => ['name_ar' => 'خزامى', 'image' => 'lavender.jpg'],
            'Sichuan Pepper' => ['name_ar' => 'فلفل سيتشوان', 'image' => 'sichuan_pepper.jpg'],
            'Ambroxan' => ['name_ar' => 'أمبروكسان', 'image' => 'ambroxan.jpg'],
            'Grapefruit' => ['name_ar' => 'جريب فروت', 'image' => 'grapefruit.jpg'],
            'Lemon' => ['name_ar' => 'ليمون', 'image' => 'lemon.jpg'],
            'Ginger' => ['name_ar' => 'زنجبيل', 'image' => 'ginger.jpg'],
            'Sandalwood' => ['name_ar' => 'خشب الصندل', 'image' => 'sandalwood.jpg'],
            'Cedarwood' => ['name_ar' => 'خشب الأرز', 'image' => 'cedarwood.jpg'],
            'Saffron' => ['name_ar' => 'زعفران', 'image' => 'saffron.jpg'],
            'Almond' => ['name_ar' => 'لوز', 'image' => 'almond.jpg'],
        ];

        $notes = [];
        foreach ($notesData as $nameEn => $info) {
            $notes[Str::slug($nameEn)] = Note::updateOrCreate(
                ['slug' => Str::slug($nameEn)],
                [
                    'name_en' => $nameEn, 
                    'name_ar' => $info['name_ar'], 
                    'image' => 'notes/' . $info['image']
                ]
            );
        }

        // 6. Create Accords
        $accordsData = [
            'Woody' => ['name_ar' => 'خشبي', 'color' => '#8B5A2B'],
            'Citrus' => ['name_ar' => 'حمضيات', 'color' => '#FFA500'],
            'Amber' => ['name_ar' => 'عنبر', 'color' => '#FF7F24'],
            'Musky' => ['name_ar' => 'مسكي', 'color' => '#F5F5DC'],
            'Fruity' => ['name_ar' => 'فاكهي', 'color' => '#FF4500'],
            'Fresh Spicy' => ['name_ar' => 'توابل منعشة', 'color' => '#00FF7F'],
            'Leather' => ['name_ar' => 'جلدي', 'color' => '#A0522D'],
            'Floral' => ['name_ar' => 'زهري', 'color' => '#FF69B4'],
            'Sweet' => ['name_ar' => 'حلو', 'color' => '#FFC0CB'],
        ];

        $accords = [];
        foreach ($accordsData as $nameEn => $info) {
            $accords[Str::slug($nameEn)] = Accord::updateOrCreate(
                ['slug' => Str::slug($nameEn)],
                [
                    'name_en' => $nameEn, 
                    'name_ar' => $info['name_ar'], 
                    'color_hex' => $info['color']
                ]
            );
        }

        // 7. Seed Perfumes
        // Perfume 1: Creed Aventus
        $aventus = Perfume::updateOrCreate(
            ['slug' => 'creed-aventus'],
            [
                'brand_id' => $creed->id,
                'name_en' => 'Creed Aventus',
                'name_ar' => 'كريد أفينتوس',
                'gender' => 'male',
                'concentration' => 'EDP',
                'size_ml' => 100,
                'price' => 320.00,
                'old_price' => 350.00,
                'stock_status' => 'in_stock',
                'pre_order' => false,
                'delivery_days' => 2,
                'short_description_en' => 'The exceptional Aventus was inspired by the dramatic life of a historic emperor, celebrating strength, power and success.',
                'short_description_ar' => 'مستوحى من الحياة الدرامية لإمبراطور تاريخي، يحتفل بالقوة والسطوة والنجاح بعبير أروماتك فاكهي لا يقاوم.',
                'long_description_en' => '<p>Introduced in 2010, Creed Aventus has grown to become the most successful fragrance in the history of the brand. Olivier Creed, master perfumer, created this fragrance with his son Erwin.</p><p>This scent has grown to become a classic, beloved by many across the globe. It is a sophisticated blend for individuals who savour a life well-lived.</p>',
                'long_description_ar' => '<p>تم تقديم عطر كريد أفينتوس في عام 2010، ونما ليصبح العطر الأكثر نجاحاً في تاريخ الدار الفرنسية العريقة. صمم هذا العطر خبير العطور أوليفير كريد بالتعاون مع ابنه إروين.</p><p>يمثل العطر مزيجاً راقياً للأشخاص الذين يقدرون الحياة الرغيدة والنجاح.</p>',
                'year_launched' => 2010,
                'perfumer' => 'Jean-Christophe Hérault',
                'longevity' => 'long_lasting',
                'sillage' => 'strong',
                'season' => ['spring', 'summer', 'autumn'],
                'occasion' => ['business', 'casual', 'formal'],
                'source_url' => 'https://www.fragrantica.com/perfume/Creed/Aventus-9828.html',
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        PerfumeImage::updateOrCreate(
            ['perfume_id' => $aventus->id, 'sort_order' => 1],
            ['image_path' => 'perfumes/aventus1.jpg', 'is_primary' => true]
        );

        $aventus->notes()->sync([
            $notes['pineapple']->id => ['type' => 'top'],
            $notes['bergamot']->id => ['type' => 'top'],
            $notes['birch']->id => ['type' => 'middle'],
            $notes['patchouli']->id => ['type' => 'middle'],
            $notes['musk']->id => ['type' => 'base'],
            $notes['oakmoss']->id => ['type' => 'base'],
            $notes['ambergris']->id => ['type' => 'base'],
            $notes['vanilla']->id => ['type' => 'base'],
        ]);

        $aventus->accords()->sync([
            $accords['fruity']->id => ['intensity' => 100],
            $accords['citrus']->id => ['intensity' => 85],
            $accords['woody']->id => ['intensity' => 75],
            $accords['musky']->id => ['intensity' => 60],
        ]);

        // Perfume 2: Dior Sauvage
        $sauvage = Perfume::updateOrCreate(
            ['slug' => 'dior-sauvage'],
            [
                'brand_id' => $dior->id,
                'name_en' => 'Dior Sauvage',
                'name_ar' => 'ديور سوفاج',
                'gender' => 'male',
                'concentration' => 'EDP',
                'size_ml' => 100,
                'price' => 145.00,
                'old_price' => 160.00,
                'stock_status' => 'in_stock',
                'pre_order' => false,
                'delivery_days' => 3,
                'short_description_en' => 'A powerful fresh fragrance, Sauvage is raw and noble all at once.',
                'short_description_ar' => 'عطر أروماتك فوچير للرجال يتميز بتركيبة منعشة وقوية تجمع بين الخام والنبيل في آن واحد.',
                'long_description_en' => '<p>François Demachy drew inspiration from the desert in the magical hour of twilight. Mixed with the coolness of the night, the burning desert air exudes profound scents.</p>',
                'long_description_ar' => '<p>استوحى فرانسوا ديماشي الإلهام من الصحراء في ساعة الغسق السحرية، حيث يمتزج هواء الصحراء الحار مع برودة الليل ليفوح بعبير غامض وعميق.</p>',
                'year_launched' => 2018,
                'perfumer' => 'François Demachy',
                'longevity' => 'long_lasting',
                'sillage' => 'moderate',
                'season' => ['spring', 'summer', 'autumn', 'winter'],
                'occasion' => ['casual', 'night'],
                'source_url' => 'https://www.fragrantica.com/perfume/Dior/Sauvage-Eau-de-Parfum-48112.html',
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        PerfumeImage::updateOrCreate(
            ['perfume_id' => $sauvage->id, 'sort_order' => 1],
            ['image_path' => 'perfumes/sauvage1.jpg', 'is_primary' => true]
        );

        $sauvage->notes()->sync([
            $notes['bergamot']->id => ['type' => 'top'],
            $notes['sichuan-pepper']->id => ['type' => 'top'],
            $notes['lavender']->id => ['type' => 'middle'],
            $notes['ambroxan']->id => ['type' => 'base'],
            $notes['vanilla']->id => ['type' => 'base'],
        ]);

        $sauvage->accords()->sync([
            $accords['fresh-spicy']->id => ['intensity' => 100],
            $accords['citrus']->id => ['intensity' => 90],
            $accords['amber']->id => ['intensity' => 80],
            $accords['woody']->id => ['intensity' => 70],
        ]);

        // Perfume 3: Baccarat Rouge 540
        $br540 = Perfume::updateOrCreate(
            ['slug' => 'baccarat-rouge-540'],
            [
                'brand_id' => $mfk->id,
                'name_en' => 'Baccarat Rouge 540',
                'name_ar' => 'باقارات روج 540',
                'gender' => 'unisex',
                'concentration' => 'Extrait',
                'size_ml' => 70,
                'price' => 385.00,
                'old_price' => 410.00,
                'stock_status' => 'in_stock',
                'pre_order' => false,
                'delivery_days' => 4,
                'short_description_en' => 'Baccarat Rouge 540 Extrait de Parfum intensifies the power and radiance of the three breaths that compose the Eau de Parfum.',
                'short_description_ar' => 'عطر شرقي زهري للجنسين يكثف قوة وجمال النوتات الأساسية الثلاثة التي تشكل العطر الأصلي بشكل رائع.',
                'long_description_en' => '<p>Luminous and sophisticated, Baccarat Rouge 540 lays on the skin like an amber, floral and woody breeze. A poetic alchemy where the aerial notes of jasmine and saffron carry woody facets of cedarwood.</p>',
                'long_description_ar' => '<p>مضيء وراقي للغاية، يتربع باقارات روج 540 على البشرة مثل نسيم عنبري، زهري وخشبي رائع. كيمياء شاعرية تبرز بتناغم الزعفران والياسمين وخشب الأرز.</p>',
                'year_launched' => 2017,
                'perfumer' => 'Francis Kurkdjian',
                'longevity' => 'eternal',
                'sillage' => 'enormous',
                'season' => ['autumn', 'winter'],
                'occasion' => ['night', 'formal'],
                'source_url' => 'https://www.fragrantica.com/perfume/Maison-Francis-Kurkdjian/Baccarat-Rouge-540-33519.html',
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        PerfumeImage::updateOrCreate(
            ['perfume_id' => $br540->id, 'sort_order' => 1],
            ['image_path' => 'perfumes/br540_1.jpg', 'is_primary' => true]
        );

        $br540->notes()->sync([
            $notes['saffron']->id => ['type' => 'top'],
            $notes['almond']->id => ['type' => 'top'],
            $notes['jasmine']->id => ['type' => 'middle'],
            $notes['cedarwood']->id => ['type' => 'middle'],
            $notes['ambergris']->id => ['type' => 'base'],
            $notes['musk']->id => ['type' => 'base'],
        ]);

        $br540->accords()->sync([
            $accords['amber']->id => ['intensity' => 100],
            $accords['woody']->id => ['intensity' => 80],
            $accords['sweet']->id => ['intensity' => 75],
            $accords['musky']->id => ['intensity' => 60],
        ]);

        // Perfume 4: Bleu de Chanel
        $bleu = Perfume::updateOrCreate(
            ['slug' => 'bleu-de-chanel'],
            [
                'brand_id' => $chanel->id,
                'name_en' => 'Bleu de Chanel',
                'name_ar' => 'بلو دي شانيل',
                'gender' => 'male',
                'concentration' => 'Parfum',
                'size_ml' => 100,
                'price' => 175.00,
                'old_price' => 190.00,
                'stock_status' => 'in_stock',
                'pre_order' => false,
                'delivery_days' => 2,
                'short_description_en' => 'An ode to masculine freedom expressed in an aromatic-woody fragrance with a captivating trail.',
                'short_description_ar' => 'قصيدة للحرية الذكورية تتجسد في عطر خشبي أروماتك غني ذو أثر عميق وساحر.',
                'long_description_en' => '<p>Bleu de Chanel Parfum is an intense fragrance. It opens with powerful freshness, then lingers with a precious accord of New Caledonian sandalwood that unfurls its generous, powerful facets.</p>',
                'long_description_ar' => '<p>بلو دي شانيل عطر كثيف. يفتتح بانتعاش حمضي قوي، ثم يستقر على قاعدة ثمينة من خشب الصندل الكاليدوني الجديد الذي يمنحه عمقاً وجاذبية فائقة.</p>',
                'year_launched' => 2018,
                'perfumer' => 'Olivier Polge',
                'longevity' => 'long_lasting',
                'sillage' => 'moderate',
                'season' => ['spring', 'summer', 'autumn', 'winter'],
                'occasion' => ['business', 'formal'],
                'source_url' => 'https://www.fragrantica.com/perfume/Chanel/Bleu-de-Chanel-Parfum-49179.html',
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        PerfumeImage::updateOrCreate(
            ['perfume_id' => $bleu->id, 'sort_order' => 1],
            ['image_path' => 'perfumes/bleu1.jpg', 'is_primary' => true]
        );

        $bleu->notes()->sync([
            $notes['grapefruit']->id => ['type' => 'top'],
            $notes['lemon']->id => ['type' => 'top'],
            $notes['ginger']->id => ['type' => 'middle'],
            $notes['jasmine']->id => ['type' => 'middle'],
            $notes['sandalwood']->id => ['type' => 'base'],
            $notes['cedarwood']->id => ['type' => 'base'],
        ]);

        $bleu->accords()->sync([
            $accords['citrus']->id => ['intensity' => 100],
            $accords['woody']->id => ['intensity' => 90],
            $accords['fresh-spicy']->id => ['intensity' => 80],
            $accords['amber']->id => ['intensity' => 60],
        ]);
    }
}
