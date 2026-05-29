import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { VitePWA } from "vite-plugin-pwa";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/charts.js",
            ],
            refresh: true,
        }),
        VitePWA({
            outDir: "public",
            filename: "sw.js",
            registerType: "autoUpdate",
            injectRegister: null,
            includeAssets: [
                "favicon.ico",
                "favicon-192.png",
                "favicon-512.png",
                "apple-touch-icon.png",
                "icons/icon-192.png",
                "icons/icon-512.png",
                "icons/maskable-512.png",
                "icons/icon-192.svg",
                "icons/icon-512.svg",
            ],
            manifestFilename: "manifest.webmanifest",
            manifest: {
                name: "GeoCrime Masyarakat",
                short_name: "GeoCrime",
                description:
                    "PWA pelaporan kejahatan, CCTV, SOS, peta GIS, dan berita untuk masyarakat.",
                id: "/geocrime-pwa",
                start_url: "/pwa?source=pwa",
                lang: "id",
                scope: "/",
                display: "standalone",
                display_override: ["standalone"],
                prefer_related_applications: false,
                orientation: "portrait",
                background_color: "#ffffff",
                theme_color: "#3159d4",
                categories: ["utilities", "news"],
                icons: [
                    {
                        src: "/icons/icon-192.png",
                        sizes: "192x192",
                        type: "image/png",
                        purpose: "any",
                    },
                    {
                        src: "/icons/icon-512.png",
                        sizes: "512x512",
                        type: "image/png",
                        purpose: "any",
                    },
                    {
                        src: "/icons/maskable-512.png",
                        sizes: "512x512",
                        type: "image/png",
                        purpose: "maskable",
                    },
                ],
                shortcuts: [
                    {
                        name: "SOS",
                        short_name: "SOS",
                        url: "/masyarakat/sos",
                        icons: [
                            {
                                src: "/icons/icon-192.png",
                                sizes: "192x192",
                                type: "image/png",
                            },
                        ],
                    },
                    {
                        name: "Buat Laporan",
                        short_name: "Lapor",
                        url: "/masyarakat/laporan/buat",
                        icons: [
                            {
                                src: "/icons/icon-192.png",
                                sizes: "192x192",
                                type: "image/png",
                            },
                        ],
                    },
                ],
            },
            workbox: {
                cleanupOutdatedCaches: true,
                navigateFallback: null,
                globPatterns: [
                    "build/assets/*.{js,css,png}",
                    "build/manifest.webmanifest",
                    "favicon.ico",
                    "favicon-*.png",
                    "apple-touch-icon.png",
                    "icons/*.{svg,png}",
                ],
                runtimeCaching: [
                    {
                        urlPattern: ({ request, url }) =>
                            request.mode === "navigate" &&
                            url.origin === self.location.origin,
                        handler: "NetworkFirst",
                        options: {
                            cacheName: "geocrime-pages",
                            networkTimeoutSeconds: 3,
                        },
                    },
                    {
                        urlPattern: ({ url }) =>
                            url.origin === "https://fonts.bunny.net" ||
                            url.origin === "https://tile.openstreetmap.org" ||
                            url.hostname.endsWith(".tile.openstreetmap.org"),
                        handler: "CacheFirst",
                        options: {
                            cacheName: "geocrime-external-assets",
                            expiration: {
                                maxEntries: 120,
                                maxAgeSeconds: 60 * 60 * 24 * 30,
                            },
                        },
                    },
                ],
            },
            devOptions: {
                enabled: false,
            },
        }),
    ],
});
