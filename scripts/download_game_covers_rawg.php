#!/usr/bin/env php
<?php
/**
 * Download Game Cover Images from RAWG API
 *
 * RAWG is easier than IGDB - just get an API key and go!
 *
 * Get your free API key: https://rawg.io/apidocs
 *
 * Usage:
 *   php scripts/download_game_covers_rawg.php
 */

// ============================================
// CONFIGURATION
// ============================================

$API_KEY = getenv('RAWG_API_KEY') ?: 'YOUR_RAWG_API_KEY_HERE';

// Check if API key is set
if ($API_KEY === 'YOUR_RAWG_API_KEY_HERE') {
    echo "\n❌ ERROR: Please set your RAWG API key first!\n\n";
    echo "It's super easy - just 2 steps:\n\n";
    echo "1. Visit: https://rawg.io/apidocs\n";
    echo "2. Click 'Get API Key' and copy it\n\n";
    echo "Then either:\n";
    echo "  • Edit this script and paste your key, OR\n";
    echo "  • Run: export RAWG_API_KEY='your_key_here'\n\n";
    exit(1);
}

// ============================================
// GAME MAPPING
// ============================================

$games = [
    // PlayStation Games
    ['search' => 'The Last of Us Part II', 'filename' => 'the-last-of-us-2.jpg'],
    ['search' => 'God of War Ragnarok', 'filename' => 'god-of-war-ragnarok.jpg'],
    ['search' => 'Spider-Man Miles Morales', 'filename' => 'spider-man-miles-morales.jpg'],
    ['search' => 'Horizon Forbidden West', 'filename' => 'horizon-forbidden-west.jpg'],
    ['search' => 'Ghost of Tsushima', 'filename' => 'ghost-of-tsushima.jpg'],

    // Xbox Games
    ['search' => 'Halo Infinite', 'filename' => 'halo-infinite.jpg'],
    ['search' => 'Forza Horizon 5', 'filename' => 'forza-horizon-5.jpg'],
    ['search' => 'Gears 5', 'filename' => 'gears-5.jpg'],
    ['search' => 'Starfield', 'filename' => 'starfield.jpg'],

    // Nintendo Switch Games
    ['search' => 'The Legend of Zelda Tears of the Kingdom', 'filename' => 'zelda-tears-of-the-kingdom.jpg'],
    ['search' => 'Super Mario Odyssey', 'filename' => 'super-mario-odyssey.jpg'],
    ['search' => 'Animal Crossing New Horizons', 'filename' => 'animal-crossing.jpg'],
    ['search' => 'Mario Kart 8 Deluxe', 'filename' => 'mario-kart-8.jpg'],
    ['search' => 'Pokemon Scarlet', 'filename' => 'pokemon-scarlet.jpg'],

    // Multi-Platform Games
    ['search' => 'Elden Ring', 'filename' => 'elden-ring.jpg'],
    ['search' => 'Cyberpunk 2077', 'filename' => 'cyberpunk-2077.jpg'],
    ['search' => 'Red Dead Redemption 2', 'filename' => 'red-dead-redemption-2.jpg'],
    ['search' => 'Grand Theft Auto V', 'filename' => 'gta-v.jpg'],
    ['search' => 'Minecraft', 'filename' => 'minecraft.jpg'],
    ['search' => 'FIFA 24', 'filename' => 'fifa-24.jpg'],
];

// ============================================
// FUNCTIONS
// ============================================

function searchGame($gameName, $apiKey) {
    $url = "https://api.rawg.io/api/games?key=" . urlencode($apiKey) . "&search=" . urlencode($gameName) . "&page_size=1";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: GameRentalShop/1.0']);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        return null;
    }

    $data = json_decode($response, true);

    if (!empty($data['results'][0])) {
        return $data['results'][0];
    }

    return null;
}

function downloadImage($url, $destination) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 && $imageData) {
        file_put_contents($destination, $imageData);
        return true;
    }

    return false;
}

// ============================================
// MAIN SCRIPT
// ============================================

$outputDir = __DIR__ . '/../public/images/games/';

if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

echo "\n";
echo "==========================================\n";
echo "  RAWG Game Cover Downloader\n";
echo "==========================================\n";
echo "\n";

$successful = 0;
$failed = 0;
$total = count($games);

foreach ($games as $index => $game) {
    $num = $index + 1;
    echo "[{$num}/{$total}] Downloading: {$game['search']}... ";

    // Search for the game
    $gameData = searchGame($game['search'], $API_KEY);

    if (!$gameData) {
        echo "❌ Not found\n";
        $failed++;
        sleep(1); // Rate limiting
        continue;
    }

    // Check if game has a background image
    if (!isset($gameData['background_image'])) {
        echo "❌ No cover image\n";
        $failed++;
        sleep(1);
        continue;
    }

    // Download the cover image
    $imageUrl = $gameData['background_image'];
    $destination = $outputDir . $game['filename'];

    if (downloadImage($imageUrl, $destination)) {
        $size = filesize($destination);
        $sizeKB = round($size / 1024, 1);
        echo "✓ Success ({$sizeKB} KB)\n";
        $successful++;
    } else {
        echo "❌ Download failed\n";
        $failed++;
    }

    // Rate limiting - be nice to the API
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
    echo "Next steps:\n";
    echo "1. Review the downloaded images\n";
    echo "2. Commit changes: git add public/images/games/\n";
    echo "3. Run: ./start.sh to see the new images\n";
} else {
    echo "⚠️  No images were downloaded. Please check:\n";
    echo "1. Your API key is correct\n";
    echo "2. Your internet connection is working\n";
    echo "3. RAWG API is accessible\n";
}

echo "\n";
