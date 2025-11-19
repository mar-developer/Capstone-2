#!/bin/bash

# Quick Start Script for RAWG Game Cover Download
# Much simpler than IGDB - just one API key!

echo "========================================"
echo "  RAWG Game Cover Download - Quick Start"
echo "========================================"
echo ""

# Check if API key is set in environment
if [ -z "$RAWG_API_KEY" ]; then
    echo "Get your FREE API key in 2 minutes:"
    echo "1. Visit: https://rawg.io/apidocs"
    echo "2. Click 'Get API Key'"
    echo "3. Sign up (use email or Google)"
    echo "4. Copy your API key"
    echo ""

    # Prompt for API key
    read -p "Paste your RAWG API key here: " api_key

    if [ -z "$api_key" ]; then
        echo ""
        echo "❌ Error: API key is required!"
        echo ""
        echo "Get it from: https://rawg.io/apidocs"
        exit 1
    fi

    # Export for this session
    export RAWG_API_KEY="$api_key"
    echo ""
    echo "✓ API key set!"
else
    echo "✓ Using API key from environment"
fi

echo ""
echo "Starting download..."
echo ""

# Check if running in Docker
if docker-compose ps app 2>/dev/null | grep -q "Up"; then
    echo "Running via Docker..."
    docker-compose exec -T -e RAWG_API_KEY="$RAWG_API_KEY" app php scripts/download_game_covers_rawg.php
else
    echo "Running locally..."
    php scripts/download_game_covers_rawg.php
fi

echo ""
echo "Done! Your game catalog now has real cover art!"
echo ""
