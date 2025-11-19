# How to Add Real Game Cover Images

## Current Status

Your game rental shop currently uses professionally-styled placeholder images. These look good for development/demo purposes, but if you want actual game cover art, here are your options:

## Option 1: Manual Download (Easiest)

### Steps:
1. Visit game cover art sources:
   - **SteamGridDB**: https://www.steamgriddb.com/
   - **IGDB**: https://www.igdb.com/
   - **Google Images** (ensure proper licensing)
   - **Official game websites**

2. Download images for each game (recommended size: 800x600 or larger)

3. Rename them to match the filenames in the seeder:
   ```
   the-last-of-us-2.jpg
   god-of-war-ragnarok.jpg
   spider-man-miles-morales.jpg
   horizon-forbidden-west.jpg
   ghost-of-tsushima.jpg
   halo-infinite.jpg
   forza-horizon-5.jpg
   gears-5.jpg
   starfield.jpg
   zelda-tears-of-the-kingdom.jpg
   super-mario-odyssey.jpg
   animal-crossing.jpg
   mario-kart-8.jpg
   pokemon-scarlet.jpg
   elden-ring.jpg
   cyberpunk-2077.jpg
   red-dead-redemption-2.jpg
   gta-v.jpg
   minecraft.jpg
   fifa-24.jpg
   ```

4. Place them in: `/public/images/games/`

5. Commit and push your changes

## Option 2: Use RAWG API (Automated)

RAWG offers free API access for personal/hobby projects.

### Setup:
1. Get API key: https://rawg.io/apidocs
2. Create a PHP script in your project:

```php
<?php
// download_game_covers.php

$apiKey = 'YOUR_RAWG_API_KEY';
$games = [
    ['name' => 'The Last of Us Part 2', 'file' => 'the-last-of-us-2.jpg'],
    ['name' => 'God of War Ragnarok', 'file' => 'god-of-war-ragnarok.jpg'],
    // Add all games...
];

foreach ($games as $game) {
    $url = "https://api.rawg.io/api/games?key={$apiKey}&search=" . urlencode($game['name']);
    $response = json_decode(file_get_contents($url), true);

    if (!empty($response['results'][0]['background_image'])) {
        $imageUrl = $response['results'][0]['background_image'];
        file_put_contents(
            "public/images/games/{$game['file']}",
            file_get_contents($imageUrl)
        );
        echo "Downloaded: {$game['name']}\n";
    }

    sleep(1); // Rate limiting
}
```

3. Run: `php download_game_covers.php`

## Option 3: Use IGDB API (Most Complete)

IGDB has the most comprehensive game database.

### Setup:
1. Create account at: https://api.igdb.com/
2. Get Client ID and Access Token from Twitch Developer Portal
3. Use their API to fetch cover art

## Option 4: SteamGridDB API

1. Register at: https://www.steamgriddb.com/profile/preferences/api
2. Get API key
3. Use their API endpoints to download game covers

## Important Notes

### Copyright Considerations
- Game cover art is copyrighted material
- For personal/educational projects: Generally acceptable under fair use
- For commercial projects: May need licensing/permission
- Always check the terms of service for image sources

### Image Specifications
- **Recommended size**: 800x600 pixels (current format)
- **Format**: JPG or PNG
- **Quality**: High resolution for best display
- **Aspect ratio**: 4:3 (standard) or 16:9 (widescreen)

### Testing
After adding real images:
1. Clear browser cache
2. Run `./start.sh` to reseed database
3. Visit catalog page to verify images load correctly

## Current Placeholder Features

The current professional placeholders include:
- Platform badges (PS5, Xbox, Switch, Multi)
- Brand-appropriate colors
- ESRB ratings
- Rental badges
- Gradient backgrounds

These work well for:
- Development/testing
- Demonstrations
- MVP/proof of concept
- Avoiding copyright issues

## Need Help?

If you need assistance implementing any of these options, let me know!
