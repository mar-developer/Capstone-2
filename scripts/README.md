# Scripts Directory

This directory contains utility scripts for the Capstone game rental shop.

## Available Scripts

### 🏆 RECOMMENDED: RAWG API (Easiest!)

#### 1. download_game_covers_rawg.php

Downloads actual game cover images from RAWG API - **much simpler than IGDB!**

**Usage:**
```bash
# Quick interactive method (easiest!)
./scripts/quick_start_rawg.sh

# Or via Docker
docker-compose exec app php scripts/download_game_covers_rawg.php

# Or locally
php scripts/download_game_covers_rawg.php
```

**Prerequisites:**
- RAWG API key (get it in 2 minutes from https://rawg.io/apidocs)
- See RAWG_SETUP_GUIDE.md

**What it does:**
- Searches RAWG for each game in your catalog
- Downloads high-resolution cover art
- Saves to `public/images/games/`
- Shows progress for each download

**Why RAWG over IGDB:**
- ✅ Simpler setup (2 min vs 15 min)
- ✅ Just one API key (no OAuth)
- ✅ No Twitch account needed
- ✅ Same quality images

#### 2. quick_start_rawg.sh

Interactive wrapper for the RAWG download script - **start here!**

---

### Alternative: IGDB API (More Complex)

#### 3. download_game_covers.php

Downloads actual game cover images from IGDB API.

**Usage:**
```bash
# Via Docker (recommended)
docker-compose exec app php scripts/download_game_covers.php

# Locally
php scripts/download_game_covers.php
```

**Prerequisites:**
- IGDB API credentials (see IGDB_SETUP_GUIDE.md)
- Twitch Developer account
- Client ID and Access Token

**What it does:**
- Searches IGDB for each game in your catalog
- Downloads high-resolution cover art
- Saves to `public/images/games/`
- Shows progress for each download

#### 4. quick_start_igdb.sh

Interactive wrapper for the IGDB download script.

**Usage:**
```bash
./scripts/quick_start_igdb.sh
```

**What it does:**
- Prompts for IGDB credentials if not set
- Detects if running in Docker
- Runs the appropriate download command
- Handles environment variables

---

## Getting Started (Recommended: RAWG)

### Quick Method (2 minutes total):

1. **Get RAWG API key:**
   - Visit: https://rawg.io/apidocs
   - Click "Get API Key"
   - Copy your key

2. **Run the quick start script:**
   ```bash
   ./scripts/quick_start_rawg.sh
   ```

3. **Done!** Your game covers are downloaded.

### Alternative Methods:

**Set environment variable:**
```bash
export RAWG_API_KEY='your_api_key'
php scripts/download_game_covers_rawg.php
```

**Or edit the script directly:**
- Open `scripts/download_game_covers_rawg.php`
- Replace `YOUR_RAWG_API_KEY_HERE` with your actual key

---

## Getting Started (Alternative: IGDB)

1. **Read the setup guide:**
   ```bash
   cat IGDB_SETUP_GUIDE.md
   ```

2. **Get IGDB credentials:**
   - Visit: https://dev.twitch.tv/console/apps
   - Create application
   - Get Client ID and Access Token

3. **Run the quick start script:**
   ```bash
   ./scripts/quick_start_igdb.sh
   ```

4. **Or set environment variables and run directly:**
   ```bash
   export IGDB_CLIENT_ID='your_client_id'
   export IGDB_ACCESS_TOKEN='your_access_token'
   php scripts/download_game_covers.php
   ```

## Tips

- The script includes rate limiting (1 second per request)
- Total download time: ~20-30 seconds for all images
- Images are automatically saved with correct filenames
- Script shows progress and summary at the end

## Troubleshooting

See `IGDB_SETUP_GUIDE.md` for detailed troubleshooting steps.

Common issues:
- Invalid credentials → Check Client ID and Access Token
- Rate limit errors → Script already includes delays
- Download failures → Check internet connection
- Permission errors → Ensure `public/images/games/` is writable
