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
            [
                'name' => 'MacBook Pro 16"',
                'description' => 'Apple MacBook Pro 16-inch with M2 Pro chip, 16GB RAM, 512GB SSD. Perfect for professional work and creative tasks.',
                'price' => 50,
                'img_path' => 'macbook-pro.jpg',
                'category' => 'Laptop',
                'serial_code' => 'LAPTOP-001',
            ],
            [
                'name' => 'Dell XPS 15',
                'description' => 'Dell XPS 15 with Intel i7, 16GB RAM, 512GB SSD, dedicated NVIDIA graphics. Great for gaming and development.',
                'price' => 40,
                'img_path' => 'dell-xps.jpg',
                'category' => 'Laptop',
                'serial_code' => 'LAPTOP-002',
            ],
            [
                'name' => 'iPad Pro 12.9"',
                'description' => 'iPad Pro 12.9-inch with M2 chip, 256GB storage, includes Apple Pencil. Ideal for digital art and productivity.',
                'price' => 35,
                'img_path' => 'ipad-pro.jpg',
                'category' => 'Tablet',
                'serial_code' => 'TABLET-001',
            ],
            [
                'name' => 'Canon EOS R5',
                'description' => 'Professional mirrorless camera with 45MP sensor, 8K video recording. Includes 24-70mm lens.',
                'price' => 75,
                'img_path' => 'canon-r5.jpg',
                'category' => 'Camera',
                'serial_code' => 'CAMERA-001',
            ],
            [
                'name' => 'Sony A7 IV',
                'description' => 'Full-frame mirrorless camera with 33MP sensor, advanced autofocus. Perfect for photography and videography.',
                'price' => 65,
                'img_path' => 'sony-a7iv.jpg',
                'category' => 'Camera',
                'serial_code' => 'CAMERA-002',
            ],
            [
                'name' => 'DJI Mavic 3',
                'description' => 'Professional drone with Hasselblad camera, 5.1K video, 46-minute flight time. Perfect for aerial photography.',
                'price' => 80,
                'img_path' => 'dji-mavic3.jpg',
                'category' => 'Drone',
                'serial_code' => 'DRONE-001',
            ],
            [
                'name' => 'GoPro Hero 11',
                'description' => 'Action camera with 5.3K video, HyperSmooth stabilization, waterproof design. Great for adventure recording.',
                'price' => 25,
                'img_path' => 'gopro-hero11.jpg',
                'category' => 'Camera',
                'serial_code' => 'CAMERA-003',
            ],
            [
                'name' => 'PlayStation 5',
                'description' => 'Sony PlayStation 5 gaming console with controller. Experience next-gen gaming.',
                'price' => 30,
                'img_path' => 'ps5.jpg',
                'category' => 'Gaming Console',
                'serial_code' => 'GAMING-001',
            ],
            [
                'name' => 'Xbox Series X',
                'description' => 'Microsoft Xbox Series X with 1TB storage and wireless controller. 4K gaming at 120fps.',
                'price' => 30,
                'img_path' => 'xbox-series-x.jpg',
                'category' => 'Gaming Console',
                'serial_code' => 'GAMING-002',
            ],
            [
                'name' => 'Oculus Quest 3',
                'description' => 'VR headset with mixed reality capabilities, wireless design, 512GB storage. Immersive gaming and apps.',
                'price' => 45,
                'img_path' => 'oculus-quest3.jpg',
                'category' => 'VR Headset',
                'serial_code' => 'VR-001',
            ],
            [
                'name' => 'HP LaserJet Pro',
                'description' => 'High-speed laser printer with wireless connectivity, automatic duplex printing. Perfect for office use.',
                'price' => 20,
                'img_path' => 'hp-laserjet.jpg',
                'category' => 'Printer',
                'serial_code' => 'PRINTER-001',
            ],
            [
                'name' => 'Epson EcoTank Photo',
                'description' => 'Photo printer with refillable ink tanks, borderless printing up to A4 size. High-quality photo prints.',
                'price' => 25,
                'img_path' => 'epson-ecotank.jpg',
                'category' => 'Printer',
                'serial_code' => 'PRINTER-002',
            ],
            [
                'name' => 'Samsung 49" Ultrawide',
                'description' => 'Curved ultrawide monitor, 5120x1440 resolution, 120Hz refresh rate. Perfect for multitasking.',
                'price' => 40,
                'img_path' => 'samsung-ultrawide.jpg',
                'category' => 'Monitor',
                'serial_code' => 'MONITOR-001',
            ],
            [
                'name' => 'LG 27" 4K Monitor',
                'description' => '4K IPS monitor with HDR10 support, USB-C connectivity, height adjustable stand.',
                'price' => 30,
                'img_path' => 'lg-4k-monitor.jpg',
                'category' => 'Monitor',
                'serial_code' => 'MONITOR-002',
            ],
            [
                'name' => 'Rode VideoMic Pro',
                'description' => 'Professional shotgun microphone for video recording, battery or phantom powered.',
                'price' => 15,
                'img_path' => 'rode-videomic.jpg',
                'category' => 'Audio',
                'serial_code' => 'AUDIO-001',
            ],
            [
                'name' => 'Shure SM7B',
                'description' => 'Professional studio microphone, excellent for podcasting and voice recording.',
                'price' => 20,
                'img_path' => 'shure-sm7b.jpg',
                'category' => 'Audio',
                'serial_code' => 'AUDIO-002',
            ],
            [
                'name' => 'Aputure 300d II',
                'description' => 'Professional LED light, 300W output, daylight balanced. Perfect for video production.',
                'price' => 35,
                'img_path' => 'aputure-300d.jpg',
                'category' => 'Lighting',
                'serial_code' => 'LIGHT-001',
            ],
            [
                'name' => 'Godox SL-60W',
                'description' => 'LED video light with Bowens mount, 60W output, adjustable color temperature.',
                'price' => 25,
                'img_path' => 'godox-sl60.jpg',
                'category' => 'Lighting',
                'serial_code' => 'LIGHT-002',
            ],
            [
                'name' => 'Manfrotto Tripod',
                'description' => 'Professional aluminum tripod with fluid head, supports up to 8kg. Essential for stable shots.',
                'price' => 15,
                'img_path' => 'manfrotto-tripod.jpg',
                'category' => 'Accessories',
                'serial_code' => 'ACC-001',
            ],
            [
                'name' => 'Peak Design Travel Backpack',
                'description' => 'Camera backpack with customizable dividers, weatherproof, fits 45L of gear.',
                'price' => 10,
                'img_path' => 'peak-design-bag.jpg',
                'category' => 'Accessories',
                'serial_code' => 'ACC-002',
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
