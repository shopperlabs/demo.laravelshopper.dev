<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Shopper\Core\Enum\ProductType;

class DemoProductsSeeder extends Seeder
{
    private const CURRENCY_XAF_ID = 151;

    private const META_KEYS = ['brand_slug', 'category_slug', 'price', 'compare_price', 'cost_price'];

    public function run(): void
    {
        collect($this->products())->each(function (array $data): void {
            $product = Product::query()->create([
                ...Arr::except($data, self::META_KEYS),
                'slug' => Str::slug($data['name']),
                'is_visible' => true,
                'published_at' => now(),
                'brand_id' => Brand::query()->where('slug', data_get($data, 'brand_slug'))->value('id'),
            ]);

            $categoryId = Category::query()->where('slug', data_get($data, 'category_slug'))->value('id');

            if ($categoryId) {
                DB::table(shopper_table('product_has_relations'))->insert([
                    ['product_id' => $product->id, 'productable_type' => 'category', 'productable_id' => $categoryId],
                    ['product_id' => $product->id, 'productable_type' => 'channel', 'productable_id' => 1],
                ]);
            }

            $product->prices()->create([
                'amount' => data_get($data, 'price'),
                'compare_amount' => data_get($data, 'compare_price'),
                'cost_amount' => data_get($data, 'cost_price'),
                'currency_id' => self::CURRENCY_XAF_ID,
            ]);
        });

        $this->command->info('8 demo products created.');
    }

    /** @return list<array<string, mixed>> */
    private function products(): array
    {
        return [
            [
                'name' => 'Sony WH-1000XM5',
                'type' => ProductType::Standard->value,
                'description' => 'Industry-leading noise canceling headphones with Auto NC Optimizer, crystal-clear hands-free calling, and up to 30 hours of battery life. Features multipoint connection for seamless switching between devices.',
                'summary' => 'Casque sans fil avec réduction de bruit leader du marché et 30h d\'autonomie.',
                'sku' => 'SONY-WH1000XM5-BLK',
                'barcode' => '4548736132610',
                'weight_value' => 0.25,
                'featured' => true,
                'security_stock' => 5,
                'seo_title' => 'Sony WH-1000XM5 Wireless Noise Canceling',
                'seo_description' => 'Casque sans fil avec reduction de bruit, 30h autonomie, connexion multipoint et appels cristallins.',
                'brand_slug' => 'sony',
                'category_slug' => 'electronics-audio',
                'price' => 249900,
                'compare_price' => 299000,
                'cost_price' => 150000,
            ],
            [
                'name' => 'Moleskine Classic Notebook Large',
                'type' => ProductType::Standard->value,
                'description' => 'The iconic Moleskine Classic Notebook in large format (13x21 cm). Features 240 ruled pages of ivory-colored 70 gsm acid-free paper, a hard cover, elastic closure, bookmark ribbon, and expandable inner pocket.',
                'summary' => 'Carnet classique grand format avec 240 pages lignées et couverture rigide.',
                'sku' => 'MLSK-CLASSIC-LG-BLK',
                'barcode' => '8058647626581',
                'weight_value' => 0.32,
                'height_value' => 21.0,
                'width_value' => 13.0,
                'depth_value' => 1.5,
                'security_stock' => 20,
                'seo_title' => 'Moleskine Classic Large Ruled Notebook',
                'seo_description' => 'Carnet iconique couverture rigide, 240 pages lignees, fermeture elastique et poche interieure.',
                'brand_slug' => 'moleskine',
                'category_slug' => 'office-stationery',
                'price' => 15900,
                'compare_price' => null,
                'cost_price' => 5000,
            ],
            [
                'name' => 'Yeti Rambler 26 oz Bottle',
                'type' => ProductType::Standard->value,
                'description' => 'The Yeti Rambler 26 oz Bottle is built with kitchen-grade 18/8 stainless steel and double-wall vacuum insulation to keep your drinks cold (or hot) until the last sip. Features a TripleHaul cap with a leakproof design.',
                'summary' => 'Bouteille isotherme en acier inoxydable avec isolation double paroi.',
                'sku' => 'YETI-RAM26-NVY',
                'barcode' => '0888830130339',
                'weight_value' => 0.45,
                'height_value' => 27.0,
                'width_value' => 9.0,
                'security_stock' => 15,
                'seo_title' => 'Yeti Rambler 26oz Stainless Steel Bottle',
                'seo_description' => 'Bouteille isotherme double paroi avec bouchon TripleHaul etanche. Garde vos boissons chaudes ou froides.',
                'brand_slug' => 'yeti',
                'category_slug' => 'sports-outdoors',
                'price' => 24900,
                'compare_price' => null,
                'cost_price' => 9500,
            ],
            [
                'name' => 'Adobe Creative Cloud - All Apps (1 Year)',
                'type' => ProductType::Virtual->value,
                'description' => 'Get access to the entire collection of 20+ creative desktop and mobile apps including Photoshop, Illustrator, InDesign, Premiere Pro, and Acrobat Pro. Includes 100 GB of cloud storage, Adobe Fonts, and Adobe Portfolio.',
                'summary' => 'Abonnement annuel à la suite complète Adobe : Photoshop, Illustrator, Premiere Pro et plus.',
                'sku' => 'ADOBE-CC-ALL-1Y',
                'featured' => true,
                'seo_title' => 'Adobe Creative Cloud All Apps - Annual Plan',
                'seo_description' => 'Suite complete de 20+ apps creatives : Photoshop, Illustrator, Premiere Pro. 100 Go stockage cloud inclus.',
                'brand_slug' => 'adobe',
                'category_slug' => 'software-licenses',
                'price' => 359000,
                'compare_price' => 395000,
                'cost_price' => 240000,
            ],
            [
                'name' => 'MasterClass Annual Membership',
                'type' => ProductType::Virtual->value,
                'description' => 'Unlimited access to 200+ classes taught by world-renowned instructors across cooking, writing, music, film, business, and more. Stream on any device, download lessons for offline viewing, and access class workbooks.',
                'summary' => 'Accès illimité à 200+ cours en ligne par des experts mondiaux.',
                'sku' => 'MCLASS-ANNUAL-2024',
                'seo_title' => 'MasterClass Annual Membership - All Access',
                'seo_description' => 'Acces illimite a 200+ cours en ligne par des instructeurs de renommee mondiale.',
                'brand_slug' => 'masterclass',
                'category_slug' => 'online-courses',
                'price' => 72000,
                'compare_price' => 108000,
                'cost_price' => null,
            ],
            [
                'name' => 'Xiaomi Electric Scooter 4 Pro (2nd Gen)',
                'type' => ProductType::External->value,
                'description' => 'Powerful electric scooter with a 700W motor, 60 km range, and 25 km/h top speed. Features a 10-inch tubeless tire, dual braking system, and an integrated LED display. Foldable design for easy storage and transport.',
                'summary' => 'Trottinette électrique pliable avec moteur 700W et 60 km d\'autonomie.',
                'sku' => 'XMI-SCOOT4PRO-G2',
                'barcode' => '6941812756423',
                'featured' => true,
                'seo_title' => 'Xiaomi Electric Scooter 4 Pro 2nd Gen',
                'seo_description' => 'Moteur 700W, 60 km autonomie, pneus tubeless. Trottinette electrique pliable pour la ville.',
                'brand_slug' => 'xiaomi',
                'category_slug' => 'mobility',
                'price' => 489000,
                'compare_price' => 549000,
                'cost_price' => 320000,
            ],
            [
                'name' => 'Anker PowerCore 26800mAh Portable Charger',
                'type' => ProductType::External->value,
                'description' => 'Ultra-high capacity 26800mAh portable charger with dual USB-C input/output and PowerIQ technology for optimized charging. Charges an iPhone 14 over 6 times or a MacBook Air once. Compact design with LED power indicator.',
                'summary' => 'Batterie externe ultra-capacité 26800mAh avec double USB-C et charge intelligente.',
                'sku' => 'ANKR-PC26800-BLK',
                'barcode' => '0194644153489',
                'seo_title' => 'Anker PowerCore 26800 Portable Power Bank',
                'seo_description' => 'Batterie externe 26800mAh ultra-capacite avec double USB-C. Charge iPhone 6+ fois.',
                'brand_slug' => 'anker',
                'category_slug' => 'electronics',
                'price' => 35900,
                'compare_price' => 44900,
                'cost_price' => 17000,
            ],
            [
                'name' => 'Nike Air Max 90',
                'type' => ProductType::Variant->value,
                'description' => 'Nothing as icons like the icons. The Nike Air Max 90 stays true to its OG running roots with the iconic Waffle outsole, stitched overlays, and classic TPU accents. Fresh colors give a modern look while Max Air cushioning adds comfort to your journey.',
                'summary' => 'Sneaker iconique avec semelle Waffle, overlays cousus et coussin Air Max.',
                'sku' => 'NIKE-AM90-WHT',
                'barcode' => '0196154756891',
                'weight_value' => 0.85,
                'featured' => true,
                'security_stock' => 3,
                'seo_title' => 'Nike Air Max 90 - Classic Sneaker',
                'seo_description' => 'Air Max 90 iconique avec semelle Waffle, overlays cousus et coussin Max Air. Style et confort.',
                'brand_slug' => 'nike',
                'category_slug' => 'shoes',
                'price' => 79900,
                'compare_price' => 89900,
                'cost_price' => 33000,
            ],
        ];
    }
}
