#!/usr/bin/env php
<?php
/**
 * Download Game Cover Images from IGDB API
 *
 * This script downloads actual game cover art from IGDB (Internet Game Database).
 * You need to obtain Client ID and Access Token from Twitch Developer Portal.
 *
 * Usage:
 *   php scripts/download_game_covers.php
 *
 * Before running:
 *   1. Get credentials from https://dev.twitch.tv/console/apps
 *   2. Set CLIENT_ID and ACCESS_TOKEN in this file or as environment variables
 */

// ============================================
// CONFIGURATION - Add your credentials here
// ============================================

$CLIENT_ID = getenv('IGDB_CLIENT_ID') ?: 'YOUR_CLIENT_ID_HERE';
$ACCESS_TOKEN = getenv('IGDB_ACCESS_TOKEN') ?: 'YOUR_ACCESS_TOKEN_HERE';

// Check if credentials are set
if ($CLIENT_ID === 'YOUR_CLIENT_ID_HERE' || $ACCESS_TOKEN === 'YOUR_ACCESS_TOKEN_HERE') {
    echo "\n❌ ERROR: Please set your IGDB API credentials first!\n\n";
    echo "Follow these steps:\n";
    echo "1. Visit: https://dev.twitch.tv/console/apps\n";
    echo "2. Create a new application (or use existing)\n";
    echo "3. Get your Client ID\n";
    echo "4. Generate Access Token using:\n";
    echo "   curl -X POST 'https://id.twitch.tv/oauth2/token?client_id=YOUR_CLIENT_ID&client_secret=YOUR_CLIENT_SECRET&grant_type=client_credentials'\n\n";
    echo "5. Update this script with your credentials, OR\n";
    echo "6. Set environment variables:\n";
    echo "   export IGDB_CLIENT_ID='your_client_id'\n";
    echo "   export IGDB_ACCESS_TOKEN='your_access_token'\n\n";
    exit(1);
}

// ============================================
// GAME MAPPING
// ============================================

$games = [
    // PlayStation Games
    [
        'search' => 'The Last of Us Part II',
        'filename' => 'the-last-of-us-2.jpg',
        'platforms' => ['PlayStation 4', 'PlayStation 5']
    ],
    [
        'search' => 'God of War Ragnarök',
        'filename' => 'god-of-war-ragnarok.jpg',
        'platforms' => ['PlayStation 4', 'PlayStation 5']
    ],
    [
        'search' => 'Spider-Man Miles Morales',
        'filename' => 'spider-man-miles-morales.jpg',
        'platforms' => ['PlayStation 4', 'PlayStation 5']
    ],
    [
        'search' => 'Horizon Forbidden West',
        'filename' => 'horizon-forbidden-west.jpg',
        'platforms' => ['PlayStation 4', 'PlayStation 5']
    ],
    [
        'search' => 'Ghost of Tsushima',
        'filename' => 'ghost-of-tsushima.jpg',
        'platforms' => ['PlayStation 4']
    ],

    // Xbox Games
    [
        'search' => 'Halo Infinite',
        'filename' => 'halo-infinite.jpg',
        'platforms' => ['Xbox Series X|S', 'Xbox One']
    ],
    [
        'search' => 'Forza Horizon 5',
        'filename' => 'forza-horizon-5.jpg',
        'platforms' => ['Xbox Series X|S', 'Xbox One']
    ],
    [
        'search' => 'Gears 5',
        'filename' => 'gears-5.jpg',
        'platforms' => ['Xbox One']
    ],
    [
        'search' => 'Starfield',
        'filename' => 'starfield.jpg',
        'platforms' => ['Xbox Series X|S']
    ],

    // Nintendo Switch Games
    [
        'search' => 'The Legend of Zelda Tears of the Kingdom',
        'filename' => 'zelda-tears-of-the-kingdom.jpg',
        'platforms' => ['Nintendo Switch']
    ],
    [
        'search' => 'Super Mario Odyssey',
        'filename' => 'super-mario-odyssey.jpg',
        'platforms' => ['Nintendo Switch']
    ],
    [
        'search' => 'Animal Crossing New Horizons',
        'filename' => 'animal-crossing.jpg',
        'platforms' => ['Nintendo Switch']
    ],
    [
        'search' => 'Mario Kart 8 Deluxe',
        'filename' => 'mario-kart-8.jpg',
        'platforms' => ['Nintendo Switch']
    ],
    [
        'search' => 'Pokémon Scarlet',
        'filename' => 'pokemon-scarlet.jpg',
        'platforms' => ['Nintendo Switch']
    ],

    // Multi-Platform Games
    [
        'search' => 'Elden Ring',
        'filename' => 'elden-ring.jpg',
        'platforms' => ['PC', 'PlayStation', 'Xbox']
    ],
    [
        'search' => 'Cyberpunk 2077',
        'filename' => 'cyberpunk-2077.jpg',
        'platforms' => ['PC', 'PlayStation', 'Xbox']
    ],
    [
        'search' => 'Red Dead Redemption 2',
        'filename' => 'red-dead-redemption-2.jpg',
        'platforms' => ['PC', 'PlayStation', 'Xbox']
    ],
    [
        'search' => 'Grand Theft Auto V',
        'filename' => 'gta-v.jpg',
        'platforms' => ['PC', 'PlayStation', 'Xbox']
    ],
    [
        'search' => 'Minecraft',
        'filename' => 'minecraft.jpg',
        'platforms' => ['PC', 'PlayStation', 'Xbox', 'Nintendo Switch']
    ],
    [
        'search' => 'FIFA 24',
        'filename' => 'fifa-24.jpg',
        'platforms' => ['PC', 'PlayStation', 'Xbox', 'Nintendo Switch']
    ],
];

// ============================================
// FUNCTIONS
// ============================================

function queryIGDB($endpoint, $query, $clientId, $accessToken) {
    $url = "https://api.igdb.com/v4/{$endpoint}";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Client-ID: {$clientId}",
        "Authorization: Bearer {$accessToken}",
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        echo "HTTP Error {$httpCode}: {$response}\n";
        return null;
    }

    return json_decode($response, true);
}

function downloadImage($url, $destination) {
    // Convert thumbnail URL to large cover
    $url = str_replace('t_thumb', 't_cover_big', $url);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

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
echo "  IGDB Game Cover Downloader\n";
echo "==========================================\n";
echo "\n";

$successful = 0;
$failed = 0;
$total = count($games);

foreach ($games as $index => $game) {
    $num = $index + 1;
    echo "[{$num}/{$total}] Downloading: {$game['search']}... ";

    // Search for the game
    $query = "search \"{$game['search']}\"; fields name,cover.url,cover.image_id; limit 1;";
    $results = queryIGDB('games', $query, $CLIENT_ID, $ACCESS_TOKEN);

    if (!$results || empty($results)) {
        echo "❌ Not found\n";
        $failed++;
        sleep(1); // Rate limiting
        continue;
    }

    $gameData = $results[0];

    // Check if game has a cover
    if (!isset($gameData['cover']['url'])) {
        echo "❌ No cover image\n";
        $failed++;
        sleep(1);
        continue;
    }

    // Download the cover image
    $imageUrl = 'https:' . $gameData['cover']['url'];
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

    // Rate limiting - IGDB allows 4 requests per second
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
    echo "1. Your API credentials are correct\n";
    echo "2. Your internet connection is working\n";
    echo "3. IGDB API is accessible\n";
}

echo "\n";
