#!/bin/bash

# Quick Start Script for IGDB Game Cover Download
# This script helps you set up and run the IGDB downloader quickly

echo "========================================"
echo "  IGDB Game Cover Download - Quick Start"
echo "========================================"
echo ""

# Check if credentials are set in environment
if [ -z "$IGDB_CLIENT_ID" ] || [ -z "$IGDB_ACCESS_TOKEN" ]; then
    echo "⚠️  API Credentials not found in environment variables"
    echo ""
    echo "Please provide your IGDB API credentials:"
    echo ""

    # Prompt for Client ID
    read -p "Enter your IGDB Client ID: " client_id
    read -p "Enter your IGDB Access Token: " access_token

    if [ -z "$client_id" ] || [ -z "$access_token" ]; then
        echo ""
        echo "❌ Error: Both Client ID and Access Token are required!"
        echo ""
        echo "To get credentials:"
        echo "1. Visit: https://dev.twitch.tv/console/apps"
        echo "2. Create an application"
        echo "3. Get Client ID and Secret"
        echo "4. Generate token with:"
        echo "   curl -X POST 'https://id.twitch.tv/oauth2/token?client_id=YOUR_ID&client_secret=YOUR_SECRET&grant_type=client_credentials'"
        echo ""
        echo "See IGDB_SETUP_GUIDE.md for detailed instructions"
        exit 1
    fi

    # Export for this session
    export IGDB_CLIENT_ID="$client_id"
    export IGDB_ACCESS_TOKEN="$access_token"

    echo ""
    echo "✓ Credentials set for this session"
else
    echo "✓ Using credentials from environment variables"
fi

echo ""
echo "Starting download..."
echo ""

# Check if running in Docker
if docker-compose ps app 2>/dev/null | grep -q "Up"; then
    echo "Running via Docker..."
    docker-compose exec -T -e IGDB_CLIENT_ID="$IGDB_CLIENT_ID" -e IGDB_ACCESS_TOKEN="$IGDB_ACCESS_TOKEN" app php scripts/download_game_covers.php
else
    echo "Running locally..."
    php scripts/download_game_covers.php
fi

echo ""
echo "Done!"
echo ""
