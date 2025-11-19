# RAWG API Setup Guide - Quick & Easy!

RAWG is **much simpler than IGDB** - no OAuth, no Twitch account, just get an API key and go!

## Why RAWG Instead of IGDB?

| Feature | RAWG | IGDB |
|---------|------|------|
| Setup Steps | 2 steps | 5 steps |
| Authentication | Simple API key | OAuth + Twitch |
| Account Required | RAWG account | Twitch account |
| Token Generation | Instant | Manual curl command |
| Complexity | ⭐ Easy | ⭐⭐⭐ Complex |
| Setup Time | **2 minutes** | 10-15 minutes |

---

## Quick Setup (2 Minutes!)

### Step 1: Get Your API Key

1. Visit: **https://rawg.io/apidocs**
2. Click **"Get API Key"** button
3. Sign up with email (or use Google/Discord)
4. Copy your API key from the dashboard

**That's it!** No OAuth, no client secrets, no token generation. Just one key.

---

### Step 2: Run the Download Script

#### Option A: Quick Interactive Script

```bash
./scripts/quick_start_rawg.sh
```

The script will prompt you for your API key and download everything automatically.

#### Option B: Set Environment Variable

```bash
export RAWG_API_KEY='your_api_key_here'
docker-compose exec app php scripts/download_game_covers_rawg.php
```

#### Option C: Edit the Script

Open `scripts/download_game_covers_rawg.php` and replace:
```php
$API_KEY = getenv('RAWG_API_KEY') ?: 'YOUR_RAWG_API_KEY_HERE';
```

With:
```php
$API_KEY = getenv('RAWG_API_KEY') ?: 'your_actual_api_key';
```

Then run:
```bash
php scripts/download_game_covers_rawg.php
```

---

## Expected Output

```
==========================================
  RAWG Game Cover Downloader
==========================================

[1/20] Downloading: The Last of Us Part II... ✓ Success (234.5 KB)
[2/20] Downloading: God of War Ragnarok... ✓ Success (198.7 KB)
[3/20] Downloading: Spider-Man Miles Morales... ✓ Success (256.3 KB)
...
[20/20] Downloading: FIFA 24... ✓ Success (187.2 KB)

==========================================
  Summary
==========================================
Total games:     20
✓ Successful:    20
❌ Failed:        0

Images saved to: public/images/games/
```

**Download time:** ~30 seconds

---

## What You Get

RAWG provides:
- ✅ High-quality game cover images
- ✅ Official artwork
- ✅ Large resolution (suitable for web display)
- ✅ All your games (PlayStation, Xbox, Nintendo, Multi-platform)

---

## API Limits

**RAWG Free Tier:**
- 20,000 requests per month
- You only need 20 requests (one per game)
- That's 0.1% of your monthly limit!
- No credit card required
- No time limit

**Our script:**
- Downloads 20 images
- Takes ~30 seconds
- Uses 20 of your 20,000 monthly requests

---

## Troubleshooting

### "Invalid API key"
- Double-check you copied the entire key
- Make sure there are no extra spaces
- Verify the key is from https://rawg.io/apidocs

### "Game not found"
- RAWG has 500,000+ games, all yours should be there
- The script will show which games failed
- Usually means a typo in the game name

### Downloads fail
- Check internet connection
- Verify `public/images/games/` directory is writable
- Check RAWG API status at https://rawg.io

---

## After Download

1. **Verify images:**
   ```bash
   ls -lh public/images/games/
   ```

2. **Commit changes:**
   ```bash
   git add public/images/games/
   git commit -m "Add real game covers from RAWG API"
   git push
   ```

3. **Restart app:**
   ```bash
   ./start.sh
   ```

4. **View in browser:**
   http://localhost:8000 - Your catalog now has real game covers!

---

## Comparison with Other APIs

### vs. IGDB
- ✅ **Simpler**: No OAuth, no Twitch account
- ✅ **Faster**: 2 min setup vs 15 min
- ✅ **Same quality**: Both have excellent images
- ✅ **Better UX**: One API key vs multiple tokens

### vs. CheapShark
- ✅ **Complete catalog**: Has all your games
- ✅ **Console games**: PlayStation, Xbox, Nintendo
- ✅ **Better images**: Higher quality covers

### vs. FreeToGame
- ✅ **Your games**: FreeToGame only has F2P games
- ✅ **AAA titles**: RAWG has all major releases

---

## License Note

**Important:** Game cover art is copyrighted material.

- ✅ **Educational/Personal**: Acceptable under fair use
- ✅ **Portfolio/Demo**: Usually okay with attribution
- ❌ **Commercial**: May require licensing

Consider adding attribution in your app's footer:
```
Game data provided by RAWG.io
```

---

## Questions?

- **API Docs**: https://api.rawg.io/docs/
- **Get API Key**: https://rawg.io/apidocs
- **API Status**: https://rawg.io

---

**Total time to get real game covers: 2-3 minutes!** 🚀
