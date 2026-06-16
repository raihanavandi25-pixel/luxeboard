<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Hardcoded Executive Admin Account
        $admin = User::create([
            'name' => 'Executive Admin',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create a regular customer for testing
        $customer = User::create([
            'name' => 'Gamer Sejati',
            'email' => 'gamer@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Pre-populate Luxury Categories
        $categories = [
            [
                'name' => 'Board Game',
                'slug' => 'board-game',
                'icon' => 'puzzle-piece',
            ],
            [
                'name' => 'Expansion Set',
                'slug' => 'expansion-set',
                'icon' => 'plus-circle',
            ],
            [
                'name' => 'Card Sleeves & Playmat',
                'slug' => 'card-sleeves-playmat',
                'icon' => 'shield-check',
            ]
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = Category::create($cat);
        }

        // 3. Pre-populate Elite Global Tabletop Publishing Studios (Brands)
        $brands = [
            [
                'name' => 'Stonemaier Games',
                'slug' => 'stonemaier-games',
                'description' => 'Known for beautiful, high-strategy luxury board games such as Wingspan and Scythe.',
                'logo_url' => null,
            ],
            [
                'name' => 'Fantasy Flight Games',
                'slug' => 'fantasy-flight-games',
                'description' => 'Elite publisher of deep narrative-driven card games and highly detailed thematic miniature games.',
                'logo_url' => null,
            ],
            [
                'name' => 'Ravensburger',
                'slug' => 'ravensburger',
                'description' => 'A premier historic German board game and puzzle publisher, delivering classic high-quality components.',
                'logo_url' => null,
            ],
            [
                'name' => 'Czech Games Edition',
                'slug' => 'czech-games-edition',
                'description' => 'Innovative designer of engaging intellectual games and modern cooperative masterpieces.',
                'logo_url' => null,
            ],
            [
                'name' => 'Asmodee',
                'slug' => 'asmodee',
                'description' => 'Global leader in tabletop game distribution and publisher of beloved modern classics.',
                'logo_url' => null,
            ]
        ];

        $brandModels = [];
        foreach ($brands as $brand) {
            $brandModels[$brand['slug']] = Brand::create($brand);
        }

        // 4. Pre-populate Products
        $products = [
            [
                'category_slug' => 'board-game',
                'brand_slug' => 'stonemaier-games',
                'name' => 'Scythe: Collector\'s Edition',
                'slug' => 'scythe-collectors-edition',
                'description' => 'Scythe is an engine-building, asymmetric board game set in an alternate-history 1920s period. It is a time of farming and war, broken hearts and rusted gears, innovation and valor. The Premium Edition features custom resin resources and metal coins.',
                'price' => 1499000.00,
                'stock' => 15,
                'image_path' => null, // Will render styled name on Moss Green fallback canvas
                'rating' => 4.9,
                'reviews_count' => 128,
                'sold_count' => 54,
                'player_count' => '1-5 Players',
                'play_time' => '90-115 Mins',
                'min_age' => 14,
                'is_featured' => true,
                'is_new' => false,
            ],
            [
                'category_slug' => 'board-game',
                'brand_slug' => 'stonemaier-games',
                'name' => 'Wingspan',
                'slug' => 'wingspan',
                'description' => 'Wingspan is a competitive, medium-weight, card-driven, network-building board game. You are bird enthusiasts—researchers, bird watchers, ornithologists, and collectors—seeking to discover and attract the best birds to your network of wildlife preserves.',
                'price' => 950000.00,
                'stock' => 24,
                'image_path' => null,
                'rating' => 4.8,
                'reviews_count' => 245,
                'sold_count' => 110,
                'player_count' => '1-5 Players',
                'play_time' => '40-70 Mins',
                'min_age' => 10,
                'is_featured' => true,
                'is_new' => false,
            ],
            [
                'category_slug' => 'expansion-set',
                'brand_slug' => 'stonemaier-games',
                'name' => 'Scythe: Invaders from Afar',
                'slug' => 'scythe-invaders-from-afar',
                'description' => 'Expand your Scythe battles to up to 7 players with two brand new factions: Albion and Togawa. Includes new player mats, custom miniatures, and alternative action blocks.',
                'price' => 550000.00,
                'stock' => 8,
                'image_path' => null,
                'rating' => 4.7,
                'reviews_count' => 38,
                'sold_count' => 12,
                'player_count' => '1-7 Players',
                'play_time' => '90-120 Mins',
                'min_age' => 14,
                'is_featured' => false,
                'is_new' => true,
            ],
            [
                'category_slug' => 'board-game',
                'brand_slug' => 'fantasy-flight-games',
                'name' => 'Arkham Horror: The Card Game',
                'slug' => 'arkham-horror-lcg',
                'description' => 'Arkham Horror LCG is a cooperative Living Card Game set against a background of Lovecraftian cosmic horror. As the Ancient Ones seek entry to our world, investigators must work together to unravel mysteries and maintain their sanity.',
                'price' => 780000.00,
                'stock' => 12,
                'image_path' => null,
                'rating' => 4.9,
                'reviews_count' => 192,
                'sold_count' => 75,
                'player_count' => '1-2 Players',
                'play_time' => '60-120 Mins',
                'min_age' => 14,
                'is_featured' => true,
                'is_new' => false,
            ],
            [
                'category_slug' => 'card-sleeves-playmat',
                'brand_slug' => 'fantasy-flight-games',
                'name' => 'Elite Matte Sleeves - Standard Size (80 Pack)',
                'slug' => 'elite-matte-sleeves-standard',
                'description' => 'Archival-safe non-glare standard size card sleeves. Specially textured backing provides premium hand feel and effortless shuffling for heavy gaming sessions.',
                'price' => 110000.00,
                'stock' => 150,
                'image_path' => null,
                'rating' => 4.6,
                'reviews_count' => 64,
                'sold_count' => 120,
                'player_count' => 'N/A',
                'play_time' => 'N/A',
                'min_age' => 5,
                'is_featured' => false,
                'is_new' => false,
            ],
            [
                'category_slug' => 'board-game',
                'brand_slug' => 'ravensburger',
                'name' => 'The Castles of Burgundy (Special Edition)',
                'slug' => 'castles-of-burgundy-special',
                'description' => 'The legendary tile placement masterpiece, refreshed in a gorgeous high-fidelity luxury special edition. Features redesigned artwork, thick double-layered player boards, and metal coins.',
                'price' => 2400000.00,
                'stock' => 5,
                'image_path' => null,
                'rating' => 5.0,
                'reviews_count' => 84,
                'sold_count' => 18,
                'player_count' => '1-4 Players',
                'play_time' => '70-120 Mins',
                'min_age' => 12,
                'is_featured' => true,
                'is_new' => true,
            ],
            [
                'category_slug' => 'card-sleeves-playmat',
                'brand_slug' => 'ravensburger',
                'name' => 'Luxury Neoprene Playmat - Emerald Moss Edition',
                'slug' => 'luxury-playmat-emerald-moss',
                'description' => 'A custom double-stitched 3mm thick neoprene playmat featuring a rich, textured emerald-moss forest design. Smooth fabric top prevents cards from slipping while reducing noise from rolling dice.',
                'price' => 395000.00,
                'stock' => 30,
                'image_path' => null,
                'rating' => 4.8,
                'reviews_count' => 42,
                'sold_count' => 25,
                'player_count' => 'N/A',
                'play_time' => 'N/A',
                'min_age' => 3,
                'is_featured' => true,
                'is_new' => true,
            ],
            [
                'category_slug' => 'board-game',
                'brand_slug' => 'czech-games-edition',
                'name' => 'Codenames',
                'slug' => 'codenames',
                'description' => 'Codenames is an easy cooperative party game. Two rival spymasters know the secret identities of 25 agents. Their teammates know the agents only by their CODENAMES. Teammates compete to see who can make contact with all of their agents first.',
                'price' => 350000.00,
                'stock' => 45,
                'image_path' => null,
                'rating' => 4.5,
                'reviews_count' => 312,
                'sold_count' => 140,
                'player_count' => '2-8 Players',
                'play_time' => '15-30 Mins',
                'min_age' => 12,
                'is_featured' => false,
                'is_new' => false,
            ]
        ];

        foreach ($products as $prod) {
            $catId = $categoryModels[$prod['category_slug']]->id;
            $brandId = $brandModels[$prod['brand_slug']]->id;
            
            unset($prod['category_slug']);
            unset($prod['brand_slug']);
            
            $prod['category_id'] = $catId;
            $prod['brand_id'] = $brandId;
            
            Product::create($prod);
        }

        // 5. Seed Inital Notifications for test users to demonstrate interactive notifications
        $usersToSeed = [$admin, $customer];
        foreach ($usersToSeed as $usr) {
            Notification::create([
                'user_id' => $usr->id,
                'type' => 'promo',
                'title' => 'Diskon Premium Tersedia!',
                'message' => 'Gunakan kode VINTAGE20 untuk diskon 20% pembelian seluruh expansion pack minggu ini.',
                'target_url' => '/catalog?category=expansion-set',
                'read_at' => null,
            ]);

            Notification::create([
                'user_id' => $usr->id,
                'type' => 'logistics',
                'title' => 'Pengiriman Milestones Resmi',
                'message' => 'Pesanan #LXB-50912 Anda telah masuk ke kurir priority instant. Estimasi tiba hari ini.',
                'target_url' => '/invoices',
                'read_at' => null,
            ]);

            Notification::create([
                'user_id' => $usr->id,
                'type' => 'discount',
                'title' => 'Selamat Datang di Guild Tabletop',
                'message' => 'Terima kasih telah bergabung dengan luxury board game community kami.',
                'target_url' => '/about-us',
                'read_at' => now(), // Seed one read notification
            ]);
        }
    }
}
