<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;

use App\Models\Product;
use App\Models\Weather;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weatherPossibilitys = [
            'clear',
            'partly-cloudy',
            'variable-cloudiness',
            'cloudy-with-sunny-intervals',
            'cloudy',
            'thunder',
            'isolated-thunderstorms',
            'thunderstorms',
            'light-rain',
            'rain',
            'heavy-rain',
            'rain-showers',
            'rain-at-times',
            'light-sleet',
            'sleet',
            'sleet-at-times',
            'sleet-showers',
            'freezing-rain',
            'hail ',
            'light-snow',
            'snow',
            'heavy-snow',
            'snow-showers',
            'snow-at-times',
            'light-snow-at-times',
            'snowstorm',
            'mist',
            'fog',
            'squall'
        ];

        $clothes = array(
            "T-shirt",
            "Hoodie",
            "Jeans",
            "Sneakers",
            "Dress",
            "Skirt",
            "Blouse",
            "Pants",
            "Shorts",
            "Sweater",
            "Jacket",
            "Coat",
            "Scarf",
            "Hat",
            "Socks",
            "Underwear",
            "Bra",
            "Tank top",
            "Polo shirt",
            "Button-up shirt",
            "Blazer",
            "Leather jacket",
            "Denim jacket",
            "Raincoat",
            "Windbreaker",
            "Parka",
            "Puffer jacket",
            "Cardigan",
            "Jumpsuit",
            "Romper",
            "Bodysuit",
            "Suit",
            "Trousers",
            "Chinos",
            "Cargo pants",
            "Capri pants",
            "Leggings",
            "Yoga pants",
            "Swimwear",
            "Bikini",
            "One-piece swimsuit",
            "Board shorts",
            "Sarong",
            "Cover-up",
            "Sports bra",
            "Running shorts",
            "Athletic leggings",
            "Gym shorts",
            "Baseball cap",
            "Visor",
            "Beanie",
            "Fedora",
            "Beret",
            "Sun hat",
            "Bucket hat",
            "Cowboy hat",
            "Gloves",
            "Mittens",
            "Wool scarf",
            "Infinity scarf",
            "Necktie",
            "Bow tie",
            "Pocket square",
            "Belt",
            "Suspenders",
            "Loafers",
            "Oxfords",
            "Brogues",
            "Flip flops",
            "Sandals",
            "Espadrilles",
            "Mules",
            "Slides",
            "Ankle boots",
            "Chelsea boots",
            "Chukka boots",
            "Rain boots",
            "Snow boots",
            "High heels",
            "Pumps",
            "Wedges",
            "Platform shoes",
            "Stilettos",
            "Clutch",
            "Tote bag",
            "Backpack",
            "Messenger bag",
            "Crossbody bag",
            "Fanny pack",
            "Duffel bag",
            "Suitcase",
            "Weekender bag",
            "Jewelry",
            "Watch",
            "Bracelet",
            "Necklace",
            "Earrings",
            "Ring",
            "Sunglasses",
            "Reading glasses",
            "Contact lenses",
            "Prescription glasses"
        );

        $faker = Faker::create();

        foreach ($weatherPossibilitys as $index) {
            DB::table('weathers')->insert([
                'weather' => $index,
                'created_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'updated_at' => $faker->date($format = 'Y-m-d', $max = 'now')
            ]);
        }

        foreach (range(1, 500) as $index) {
            DB::table('products')->insert([
                'name' => $faker->randomElement($clothes),
                'sku' => $faker->regexify('[A-Za-z0-9]{5}'),
                'price' => rand(1, 100),
                'created_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'updated_at' => $faker->date($format = 'Y-m-d', $max = 'now')
            ]);
        }

        $products = Product::all();

        foreach ($products as $product) {
            $weatherIds = Weather::inRandomOrder()->limit(3)->pluck('id');

            $product->weathers()->attach($weatherIds);
        }

    }
}