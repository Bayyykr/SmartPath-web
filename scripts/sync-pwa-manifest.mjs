import { copyFileSync, existsSync } from 'node:fs';
import { resolve } from 'node:path';

const generatedManifest = resolve('public/build/manifest.webmanifest');
const publicManifest = resolve('public/manifest.webmanifest');

if (!existsSync(generatedManifest)) {
    console.warn('[sync-pwa-manifest] public/build/manifest.webmanifest not found. Skipping sync.');
    process.exit(0);
}

copyFileSync(generatedManifest, publicManifest);
console.log('[sync-pwa-manifest] Synced public/build/manifest.webmanifest -> public/manifest.webmanifest');
