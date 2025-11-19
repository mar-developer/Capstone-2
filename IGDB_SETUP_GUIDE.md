# IGDB API Setup Guide - Download Real Game Covers

This guide will walk you through setting up IGDB API access and downloading actual game cover images for your game rental shop.

## What is IGDB?

IGDB (Internet Game Database) is the most comprehensive video game database with high-quality cover art, metadata, and more. It's free for non-commercial use.

## Prerequisites

- PHP installed (already available via Docker)
- cURL extension enabled (already included)
- Twitch Developer account (free)

---

## Step 1: Get IGDB API Credentials

### 1.1 Create Twitch Developer Account

1. Go to: **https://dev.twitch.tv/console/apps**
2. Log in with your Twitch account (or create one if needed - it's free!)
3. Click **"Register Your Application"**

### 1.2 Register Your Application

Fill in the form:
- **Name**: `Game Rental Shop` (or any name you prefer)
- **OAuth Redirect URLs**: `http://localhost` (required but not used for API)
- **Category**: Select `Game Integration` or `Website Integration`
- Click **"Create"**

### 1.3 Get Your Client ID

1. Click on your newly created application
2. Copy the **Client ID** (you'll need this)
3. Click **"New Secret"** to generate a Client Secret
4. Copy the **Client Secret** immediately (it won't be shown again!)

### 1.4 Generate Access Token

Open your terminal and run this command (replace with your actual credentials):

```bash
curl -X POST 'https://id.twitch.tv/oauth2/token?client_id=YOUR_CLIENT_ID&client_secret=YOUR_CLIENT_SECRET&grant_type=client_credentials'
```

**Example response:**
```json
{
  "access_token": "abc123def456...",
  "expires_in": 5184000,
  "token_type": "bearer"
}
```

Copy the **access_token** value.

---

## Step 2: Configure the Download Script

You have two options:

### Option A: Edit the Script Directly (Easier)

1. Open `scripts/download_game_covers.php`
2. Find these lines near the top:
   ```php
   $CLIENT_ID = getenv('IGDB_CLIENT_ID') ?: 'YOUR_CLIENT_ID_HERE';
   $ACCESS_TOKEN = getenv('IGDB_ACCESS_TOKEN') ?: 'YOUR_ACCESS_TOKEN_HERE';
   ```
3. Replace with your actual credentials:
   ```php
   $CLIENT_ID = getenv('IGDB_CLIENT_ID') ?: 'abcd1234efgh5678';
   $ACCESS_TOKEN = getenv('IGDB_ACCESS_TOKEN') ?: 'xyz789abc123def456';
   ```

### Option B: Use Environment Variables (More Secure)

Export environment variables before running the script:

```bash
export IGDB_CLIENT_ID='your_client_id_here'
export IGDB_ACCESS_TOKEN='your_access_token_here'
```

---

## Step 3: Run the Download Script

### If Docker is Running:

```bash
docker-compose exec app php scripts/download_game_covers.php
```

### If Running Locally:

```bash
php scripts/download_game_covers.php
```

### Expected Output:

```
==========================================
  IGDB Game Cover Downloader
==========================================

[1/20] Downloading: The Last of Us Part II... ✓ Success (156.3 KB)
[2/20] Downloading: God of War Ragnarök... ✓ Success (142.7 KB)
[3/20] Downloading: Spider-Man Miles Morales... ✓ Success (178.9 KB)
...

==========================================
  Summary
==========================================
Total games:     20
✓ Successful:    20
❌ Failed:        0

Images saved to: /home/user/Capstone-2/public/images/games/

Next steps:
1. Review the downloaded images
2. Commit changes: git add public/images/games/
3. Run: ./start.sh to see the new images
```

---

## Step 4: Verify Downloaded Images

Check the images directory:

```bash
ls -lh public/images/games/
```

You should see 20 JPG files with actual game cover art!

---

## Step 5: Commit and Deploy

```bash
# Stage the new images
git add public/images/games/

# Commit
git commit -m "Add actual game cover images from IGDB"

# Push
git push
```

---

## Troubleshooting

### Error: "Invalid Client ID"
- Double-check your Client ID is correct
- Ensure there are no extra spaces
- Make sure you copied it from the Twitch Developer Console

### Error: "Invalid OAuth token"
- Your access token may have expired (they last 60 days)
- Generate a new token using the curl command from Step 1.4
- Update your script or environment variables

### Error: "❌ Not found"
- The game name might not match exactly in IGDB
- Try adjusting the search term in the script
- Some games may have different titles (e.g., "FIFA 24" vs "EA Sports FC 24")

### Error: "Rate limit exceeded"
- IGDB allows 4 requests per second
- The script includes 1-second delays between requests
- If still getting errors, increase the sleep time in the script

### Downloads fail but API works
- Check your internet connection
- Verify the output directory is writable: `public/images/games/`
- Check disk space

---

## Understanding the Script

The script (`scripts/download_game_covers.php`):

1. **Searches IGDB** for each game by name
2. **Retrieves cover art URL** from the API response
3. **Downloads high-resolution cover** (t_cover_big size)
4. **Saves to** `public/images/games/` with correct filename
5. **Includes rate limiting** to respect API limits
6. **Shows progress** for each game

---

## API Limits

**IGDB Free Tier:**
- 4 requests per second
- Unlimited total requests
- Access to full database
- Free for non-commercial use

**Our script:**
- Downloads 20 images
- Takes ~20 seconds (1 second per game)
- Well within rate limits

---

## Alternative: Manual Download

If you prefer not to use the API, you can manually download images from:

1. **IGDB Website**: https://www.igdb.com/
   - Search for each game
   - Right-click on cover art
   - "Save image as..."
   - Name it correctly (see filenames in script)

2. **SteamGridDB**: https://www.steamgriddb.com/
   - High-quality game covers
   - Free to download
   - No API required

---

## License Note

**Important:** Game cover art is copyrighted material owned by the respective publishers.

- ✅ **Educational/Personal Use**: Generally acceptable under fair use
- ✅ **Portfolio/Demo Projects**: Usually acceptable with attribution
- ❌ **Commercial Use**: May require licensing

Always check the terms of service and consider adding attribution in your app's about page.

---

## Next Steps

After downloading images:

1. ✅ Run `./start.sh` to restart with new images
2. ✅ Visit http://localhost:8000 and browse the catalog
3. ✅ Enjoy your game rental shop with real game covers!

---

## Questions?

If you encounter any issues:
1. Check the troubleshooting section above
2. Verify your API credentials
3. Check IGDB API status: https://api-status.igdb.com/
4. Review IGDB documentation: https://api-docs.igdb.com/

---

**Estimated time to complete:** 10-15 minutes

Good luck! 🎮
