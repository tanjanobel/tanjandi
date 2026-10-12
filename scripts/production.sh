#!/bin/bash
set -e

THEME_NAME=$(basename "$(pwd)")
DATE=$(date +%Y%m%d)
OUTPUT_DIR="$(pwd)/packaged/${THEME_NAME}_${DATE}"

echo "Building production package: ${THEME_NAME}-${DATE}"

# Compile production assets
npm run build

# Create output directory
mkdir -p "$OUTPUT_DIR"

# Copy only production-relevant files
rsync -av \
  --exclude='.git' \
  --exclude='.gitignore' \
  --exclude='.babelrc' \
  --exclude='.editorconfig' \
  --exclude='.stylelintrc.json' \
  --exclude='.output.txt' \
  --exclude='node_modules' \
  --exclude='src' \
  --exclude='scripts' \
  --exclude='packaged' \
  --exclude='*.map' \
  --exclude='package.json' \
  --exclude='package-lock.json' \
  --exclude='yarn.lock' \
  --exclude='webpack.config.js' \
  --exclude='gulpfile.js' \
  --exclude='README.md' \
  --exclude='languages/.gitkeep' \
  . "$OUTPUT_DIR/"

echo ""
echo "Production package created at: $OUTPUT_DIR"
