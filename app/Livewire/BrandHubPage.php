<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Brand;

class BrandHubPage extends Component
{
    public $selectedGenre = 'All';

    public $genres = [
        [
            'id' => 'grand-strategy',
            'faction' => 'Grand Strategy & Economy',
            'title' => 'Grand Strategy',
            'tag' => 'Heavy Weight',
            'abstract' => 'Medan pertempuran geopolitik dan mesin mesin mekanis. Setiap keputusan beruntun menentukan kelangsungan imperium Anda di atas papan.',
            'brands' => ['stonemaier-games', 'ravensburger'],
            'bg_gradient' => 'from-moss-deep via-moss-slate to-moss-emerald'
        ],
        [
            'id' => 'economic-simulation',
            'faction' => 'Grand Strategy & Economy',
            'title' => 'Economic Simulation',
            'tag' => 'Resource Engine',
            'abstract' => 'Sistem alokasi sumber daya yang ketat. Mengubah kelangkaan menjadi kemakmuran melalui rantai produksi yang efisien.',
            'brands' => ['stonemaier-games'],
            'bg_gradient' => 'from-moss-deep via-moss-slate to-moss-emerald'
        ],
        [
            'id' => 'social-deduction',
            'faction' => 'Social Psychology & Party',
            'title' => 'Social Deduction',
            'tag' => 'High Diplomacy',
            'abstract' => 'Medan pertempuran psikologis di mana intonasi suara, tatapan mata, dan gertakan logika bernilai jauh lebih tinggi daripada komponen fisik.',
            'brands' => ['czech-games-edition'],
            'bg_gradient' => 'from-moss-deep via-moss-slate to-moss-emerald'
        ],
        [
            'id' => 'cooperative-survival',
            'faction' => 'Tactical Survival',
            'title' => 'Cooperative Survival',
            'tag' => 'Asymmetric Rules',
            'abstract' => 'Bersatu melawan kecerdasan buatan sistem permainan. Mengoordinasikan kemampuan unik tiap pemain untuk selamat dari ancaman kosmik.',
            'brands' => ['fantasy-flight-games'],
            'bg_gradient' => 'from-moss-deep via-moss-slate to-moss-emerald'
        ],
        [
            'id' => 'asymmetric-warfare',
            'faction' => 'Tactical Survival',
            'title' => 'Asymmetric Warfare',
            'tag' => 'Direct Conflict',
            'abstract' => 'Konflik militer langsung dengan aturan dan tujuan kemenangan yang berbeda total untuk setiap faksi yang bertikai.',
            'brands' => ['non-existent-brand'], // 0 products
            'bg_gradient' => 'from-moss-deep via-moss-slate to-moss-emerald'
        ],
    ];

    public function selectFaction($faction)
    {
        $this->selectedGenre = $faction;
    }

    public function render()
    {
        // Filter genres based on the selected faction toggle
        $filteredGenres = array_filter($this->genres, function ($genre) {
            if ($this->selectedGenre === 'All') {
                return true;
            }
            return $genre['faction'] === $this->selectedGenre;
        });

        // Map product counts to each genre
        $genreData = array_map(function ($genre) {
            $count = Product::whereHas('brand', function ($q) use ($genre) {
                $q->whereIn('slug', $genre['brands']);
            })->count();

            $genre['product_count'] = $count;
            
            // Generate catalog link
            if (count($genre['brands']) > 0 && $genre['brands'][0] !== 'non-existent-brand') {
                $genre['catalog_link'] = '/catalog?brand=' . $genre['brands'][0];
            } else {
                $genre['catalog_link'] = '#';
            }

            return $genre;
        }, $filteredGenres);

        return view('livewire.brand-hub-page', [
            'genreData' => $genreData,
            'totalFactionsCount' => count(array_unique(array_column($this->genres, 'faction'))),
        ]);
    }
}
