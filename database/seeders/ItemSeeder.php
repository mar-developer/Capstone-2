<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\items;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // PlayStation Games
            [
                'name' => 'The Last of Us Part II',
                'description' => 'Epic action-adventure game following Ellie on her journey of revenge. Experience stunning graphics and emotional storytelling in this PS exclusive.',
                'price' => 5,
                'img_path' => 'the-last-of-us-2.jpg',
                'category' => 'PlayStation',
                'serial_code' => 'PS-001',
            ],
            [
                'name' => 'God of War Ragnarök',
                'description' => 'Join Kratos and Atreus in Norse mythology\'s epic conclusion. Action-packed gameplay with breathtaking visuals and an unforgettable story.',
                'price' => 6,
                'img_path' => 'god-of-war-ragnarok.jpg',
                'category' => 'PlayStation',
                'serial_code' => 'PS-002',
            ],
            [
                'name' => 'Spider-Man: Miles Morales',
                'description' => 'Swing through New York as Miles Morales. Master unique bio-electric venom powers and save the city in this thrilling Spider-Man adventure.',
                'price' => 5,
                'img_path' => 'spider-man-miles-morales.jpg',
                'category' => 'PlayStation',
                'serial_code' => 'PS-003',
            ],
            [
                'name' => 'Horizon Forbidden West',
                'description' => 'Explore a post-apocalyptic America filled with machine creatures. Stunning open world, engaging combat, and a captivating story.',
                'price' => 6,
                'img_path' => 'horizon-forbidden-west.jpg',
                'category' => 'PlayStation',
                'serial_code' => 'PS-004',
            ],
            [
                'name' => 'Ghost of Tsushima',
                'description' => 'Become a legendary samurai in feudal Japan. Beautiful open world, intense sword combat, and a tale of honor and sacrifice.',
                'price' => 5,
                'img_path' => 'ghost-of-tsushima.jpg',
                'category' => 'PlayStation',
                'serial_code' => 'PS-005',
            ],
            // Xbox Games
            [
                'name' => 'Halo Infinite',
                'description' => 'Master Chief returns in this epic sci-fi shooter. Engage in intense multiplayer battles and experience the legendary Halo campaign.',
                'price' => 5,
                'img_path' => 'halo-infinite.jpg',
                'category' => 'Xbox',
                'serial_code' => 'XB-001',
            ],
            [
                'name' => 'Forza Horizon 5',
                'description' => 'Race through stunning Mexican landscapes. The ultimate open-world racing experience with hundreds of cars and dynamic weather.',
                'price' => 5,
                'img_path' => 'forza-horizon-5.jpg',
                'category' => 'Xbox',
                'serial_code' => 'XB-002',
            ],
            [
                'name' => 'Gears 5',
                'description' => 'Intense third-person shooter action. Battle the Locust horde with powerful weapons in this blockbuster Xbox exclusive.',
                'price' => 4,
                'img_path' => 'gears-5.jpg',
                'category' => 'Xbox',
                'serial_code' => 'XB-003',
            ],
            [
                'name' => 'Starfield',
                'description' => 'Explore the vast cosmos in Bethesda\'s epic space RPG. Create your character, build ships, and discover countless planets.',
                'price' => 6,
                'img_path' => 'starfield.jpg',
                'category' => 'Xbox',
                'serial_code' => 'XB-004',
            ],
            // Nintendo Switch Games
            [
                'name' => 'The Legend of Zelda: Tears of the Kingdom',
                'description' => 'Epic adventure in Hyrule. Explore sky islands, solve puzzles, and save the kingdom in this masterpiece sequel.',
                'price' => 6,
                'img_path' => 'zelda-tears-of-the-kingdom.jpg',
                'category' => 'Nintendo Switch',
                'serial_code' => 'NSW-001',
            ],
            [
                'name' => 'Super Mario Odyssey',
                'description' => 'Join Mario on a globe-trotting 3D adventure. Capture enemies with Cappy and explore vibrant kingdoms in this beloved platformer.',
                'price' => 5,
                'img_path' => 'super-mario-odyssey.jpg',
                'category' => 'Nintendo Switch',
                'serial_code' => 'NSW-002',
            ],
            [
                'name' => 'Animal Crossing: New Horizons',
                'description' => 'Create your dream island paradise. Relax with fishing, bug catching, and island customization in this charming life sim.',
                'price' => 4,
                'img_path' => 'animal-crossing.jpg',
                'category' => 'Nintendo Switch',
                'serial_code' => 'NSW-003',
            ],
            [
                'name' => 'Mario Kart 8 Deluxe',
                'description' => 'The ultimate kart racing game. Race with friends, master unique tracks, and use items to gain the advantage.',
                'price' => 4,
                'img_path' => 'mario-kart-8.jpg',
                'category' => 'Nintendo Switch',
                'serial_code' => 'NSW-004',
            ],
            [
                'name' => 'Pokémon Scarlet',
                'description' => 'Catch, train, and battle Pokémon in the Paldea region. Open-world adventure with new Pokémon and exciting gameplay.',
                'price' => 5,
                'img_path' => 'pokemon-scarlet.jpg',
                'category' => 'Nintendo Switch',
                'serial_code' => 'NSW-005',
            ],
            // Multi-Platform Games
            [
                'name' => 'Elden Ring',
                'description' => 'Dark fantasy action RPG from FromSoftware. Explore a vast open world filled with challenging bosses and deep lore.',
                'price' => 6,
                'img_path' => 'elden-ring.jpg',
                'category' => 'Multi-Platform',
                'serial_code' => 'MP-001',
            ],
            [
                'name' => 'Cyberpunk 2077',
                'description' => 'Immerse yourself in Night City. Action RPG set in a dystopian future with branching storylines and intense combat.',
                'price' => 5,
                'img_path' => 'cyberpunk-2077.jpg',
                'category' => 'Multi-Platform',
                'serial_code' => 'MP-002',
            ],
            [
                'name' => 'Red Dead Redemption 2',
                'description' => 'Epic western adventure from Rockstar. Live the outlaw life in America\'s heartland with stunning detail and storytelling.',
                'price' => 5,
                'img_path' => 'red-dead-redemption-2.jpg',
                'category' => 'Multi-Platform',
                'serial_code' => 'MP-003',
            ],
            [
                'name' => 'Grand Theft Auto V',
                'description' => 'Experience Los Santos in this action-adventure masterpiece. Three protagonists, one massive open world, endless possibilities.',
                'price' => 4,
                'img_path' => 'gta-v.jpg',
                'category' => 'Multi-Platform',
                'serial_code' => 'MP-004',
            ],
            [
                'name' => 'Minecraft',
                'description' => 'Build, explore, and survive in blocky worlds. Unleash your creativity in this beloved sandbox game.',
                'price' => 3,
                'img_path' => 'minecraft.jpg',
                'category' => 'Multi-Platform',
                'serial_code' => 'MP-005',
            ],
            [
                'name' => 'FIFA 24',
                'description' => 'The world\'s game returns. Play with your favorite teams, master HyperMotion technology, and compete globally.',
                'price' => 4,
                'img_path' => 'fifa-24.jpg',
                'category' => 'Multi-Platform',
                'serial_code' => 'MP-006',
            ],
        ];

        foreach ($items as $itemData) {
            items::updateOrCreate(
                ['serial_code' => $itemData['serial_code']],
                $itemData
            );
        }
    }
}
