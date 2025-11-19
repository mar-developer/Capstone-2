# Scripts Directory

This directory contains utility scripts for the Capstone game rental shop.

## Available Scripts

### 1. download_game_covers.php

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

**What it does:**
- Searches IGDB for each game in your catalog
- Downloads high-resolution cover art
- Saves to `public/images/games/`
- Shows progress for each download

### 2. quick_start_igdb.sh

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

## Getting Started

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
