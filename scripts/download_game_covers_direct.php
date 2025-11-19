#!/usr/bin/env php
<?php
/**
 * Download Game Covers from Direct URLs
 * No API key required - uses publicly available images
 */

$games = [
    // Using publicly available game cover URLs
    [
        'name' => 'The Last of Us Part II',
        'filename' => 'the-last-of-us-2.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202010/2618/itbSm3suGHSSHIpmu9CCPBRy.png'
    ],
    [
        'name' => 'God of War Ragnarök',
        'filename' => 'god-of-war-ragnarok.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202207/1210/4xJ8XB3bi888QTLZYdl7Oi0s.png'
    ],
    [
        'name' => 'Spider-Man: Miles Morales',
        'filename' => 'spider-man-miles-morales.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202008/1020/PRfYtTZQsz5ARJ4x7PyESGsr.png'
    ],
    [
        'name' => 'Horizon Forbidden West',
        'filename' => 'horizon-forbidden-west.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202107/3100/aqZdSwWyy9JcQ66BxHDKrky0.png'
    ],
    [
        'name' => 'Ghost of Tsushima',
        'filename' => 'ghost-of-tsushima.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2614/NVmnBXze9ElHzU6SmykrJLIV.png'
    ],
    [
        'name' => 'Halo Infinite',
        'filename' => 'halo-infinite.jpg',
        'url' => 'https://store-images.s-microsoft.com/image/apps.42203.14495311847124170.5d1cbba4-1d60-432e-9907-c90a10ede820.4bd1acac-939c-4d68-8e4c-8d8f0b1a1613'
    ],
    [
        'name' => 'Forza Horizon 5',
        'filename' => 'forza-horizon-5.jpg',
        'url' => 'https://store-images.s-microsoft.com/image/apps.1142.14532136268454836.93048616-d21c-4d52-be67-2e3b90d3bdfc.c2fdd15c-29c1-41ce-9f99-3f49d351cba1'
    ],
    [
        'name' => 'Gears 5',
        'filename' => 'gears-5.jpg',
        'url' => 'https://store-images.s-microsoft.com/image/apps.31822.13727851868390641.c9cc5f66-aff8-406c-af6b-440838730be0.68796bde-cbf5-4eaa-a299-28a24291e143'
    ],
    [
        'name' => 'Starfield',
        'filename' => 'starfield.jpg',
        'url' => 'https://store-images.s-microsoft.com/image/apps.6422.14588595776617504.747fa96d-51e9-4f26-b9f0-60cac528f5cd.2a9e5b09-c715-4fed-b27e-8dd52fbe1148'
    ],
    [
        'name' => 'Zelda: Tears of the Kingdom',
        'filename' => 'zelda-tears-of-the-kingdom.jpg',
        'url' => 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000063714/8f7a93e259a17ea69c04d56d5d96e13e0f8c6a28e02d52e3fc9f0d89c7679f58'
    ],
    [
        'name' => 'Super Mario Odyssey',
        'filename' => 'super-mario-odyssey.jpg',
        'url' => 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000001130/3dbeb29b67b4289e5c02bdce8c70b4ca985ab894acea17adb1b81f2dba15fca5'
    ],
    [
        'name' => 'Animal Crossing: New Horizons',
        'filename' => 'animal-crossing.jpg',
        'url' => 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000027619/9989957eae3a6b545194c42fec2071675c34aadacd65e6b33fdfe7b3b6a86c3a'
    ],
    [
        'name' => 'Mario Kart 8 Deluxe',
        'filename' => 'mario-kart-8.jpg',
        'url' => 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000000153/71e9e4999ab9c2a57e33c41a11ee50d95f1db6bae0a6f2f4af0cc1c3e17a52e7'
    ],
    [
        'name' => 'Pokémon Scarlet',
        'filename' => 'pokemon-scarlet.jpg',
        'url' => 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000055674/8c2cfca8fba9ea29c8c98eff35cfadcf651b46c51f4925eca5f8ab6ca8a31a0f'
    ],
    [
        'name' => 'Elden Ring',
        'filename' => 'elden-ring.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202110/2000/aGhopp3MHppi7kooGE2Dnt8C.png'
    ],
    [
        'name' => 'Cyberpunk 2077',
        'filename' => 'cyberpunk-2077.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202111/3013/cKZ4tKNFj9C00yvHa49aihHN.png'
    ],
    [
        'name' => 'Red Dead Redemption 2',
        'filename' => 'red-dead-redemption-2.jpg',
        'url' => 'https://image.api.playstation.com/cdn/UP1004/CUSA03041_00/Hpl5MtwQgOVF9vJqlfui6SDB5Jl4oBSq.png'
    ],
    [
        'name' => 'Grand Theft Auto V',
        'filename' => 'gta-v.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202202/2821/E5F1GpqHhEk84KoBGaBrCHZU.png'
    ],
    [
        'name' => 'Minecraft',
        'filename' => 'minecraft.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2618/Y39iqyFbJBRZVKR92BYNEU90.png'
    ],
    [
        'name' => 'FIFA 24',
        'filename' => 'fifa-24.jpg',
        'url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202305/1218/zHqaWp81xsGVDuAOwWTJqsZj.png'
    ],
];

$outputDir = __DIR__ . '/../public/images/games/';

if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

echo "\n";
echo "==========================================\n";
echo "  Downloading Game Covers (No API Needed!)\n";
echo "==========================================\n";
echo "\n";

$successful = 0;
$failed = 0;
$total = count($games);

foreach ($games as $index => $game) {
    $num = $index + 1;
    echo "[{$num}/{$total}] Downloading: {$game['name']}... ";

    $ch = curl_init($game['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ]);

    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200 && $imageData && strlen($imageData) > 1000) {
        $destination = $outputDir . $game['filename'];

        // Convert PNG to JPG if needed
        $tempFile = $destination . '.tmp';
        file_put_contents($tempFile, $imageData);

        // Try to convert image
        $img = @imagecreatefromstring($imageData);
        if ($img) {
            // Resize to 800x600
            $resized = imagecreatetruecolor(800, 600);
            $width = imagesx($img);
            $height = imagesy($img);
            imagecopyresampled($resized, $img, 0, 0, 0, 0, 800, 600, $width, $height);
            imagejpeg($resized, $destination, 90);
            imagedestroy($img);
            imagedestroy($resized);
            unlink($tempFile);

            $size = filesize($destination);
            $sizeKB = round($size / 1024, 1);
            echo "✓ Success ({$sizeKB} KB)\n";
            $successful++;
        } else {
            // Just save as-is
            rename($tempFile, $destination);
            $size = filesize($destination);
            $sizeKB = round($size / 1024, 1);
            echo "✓ Success ({$sizeKB} KB)\n";
            $successful++;
        }
    } else {
        echo "❌ Failed (HTTP {$httpCode})\n";
        $failed++;
    }

    sleep(1);
}

echo "\n";
echo "==========================================\n";
echo "  Summary\n";
echo "==========================================\n";
echo "Total games:     {$total}\n";
echo "✓ Successful:    {$successful}\n";
echo "❌ Failed:        {$failed}\n";
echo "\n";

if ($successful > 0) {
    echo "Images saved to: {$outputDir}\n\n";
    echo "✓ Your game catalog now has REAL game covers!\n\n";
    echo "Next steps:\n";
    echo "1. Run: ./start.sh to restart with new images\n";
    echo "2. Visit: http://localhost:8000\n";
}

echo "\n";
