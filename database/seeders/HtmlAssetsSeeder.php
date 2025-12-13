<?php

namespace Database\Seeders;

use App\Models\HtmlAsset;
use Illuminate\Database\Seeder;

class HtmlAssetsSeeder extends Seeder
{
    public function run(): void
    {
        // Hati-hati kalau sudah ada data di production.
        // Untuk lokal/dev, truncate aman.
        HtmlAsset::query()->truncate();

        // ========== DEFAULT PER LIBRARY ==========

        // Tailwind CDN (dipakai kalau library = tailwind)
        HtmlAsset::create([
            'name' => 'Tailwind CDN',
            'logical_key' => null,
            'library' => 'tailwind',
            'type' => 'js',
            'url' => 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4',
            'position' => 'head',
            'sort_order' => 10,
        ]);

        // Bootstrap 5 CSS (library = bootstrap)
        HtmlAsset::create([
            'name' => 'Bootstrap 5 CSS',
            'logical_key' => null,
            'library' => 'bootstrap',
            'type' => 'css',
            'url' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            'position' => 'head',
            'sort_order' => 10,
        ]);

        // Bootstrap 5 JS bundle (library = bootstrap)
        HtmlAsset::create([
            'name' => 'Bootstrap 5 Bundle',
            'logical_key' => null,
            'library' => 'bootstrap',
            'type' => 'js',
            'url' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
            'position' => 'body_end',
            'sort_order' => 20,
        ]);

        // ========== LOGICAL ASSETS (dipicu oleh "assets" dari AI) ==========

        // Font Awesome (global, logical_key = fontawesome)
        HtmlAsset::create([
            'name' => 'Font Awesome 6 CSS',
            'logical_key' => 'fontawesome',
            'library' => 'global',
            'type' => 'css',
            'url' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            'position' => 'head',
            'sort_order' => 5,
        ]);

        // Swiper CSS (slider)
        HtmlAsset::create([
            'name' => 'Swiper CSS',
            'logical_key' => 'swiper',
            'library' => 'global',
            'type' => 'css',
            'url' => 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            'position' => 'head',
            'sort_order' => 30,
        ]);

        // Swiper JS
        HtmlAsset::create([
            'name' => 'Swiper JS',
            'logical_key' => 'swiper',
            'library' => 'global',
            'type' => 'js',
            'url' => 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            'position' => 'body_end',
            'sort_order' => 31,
        ]);

        // AOS (Animate On Scroll) CSS
        HtmlAsset::create([
            'name' => 'AOS CSS',
            'logical_key' => 'aos',
            'library' => 'global',
            'type' => 'css',
            'url' => 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css',
            'position' => 'head',
            'sort_order' => 40,
        ]);

        // AOS JS
        HtmlAsset::create([
            'name' => 'AOS JS',
            'logical_key' => 'aos',
            'library' => 'global',
            'type' => 'js',
            'url' => 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js',
            'position' => 'body_end',
            'sort_order' => 41,
        ]);

        // GSAP
        HtmlAsset::create([
            'name' => 'GSAP Core',
            'logical_key' => 'gsap',
            'library' => 'global',
            'type' => 'js',
            'url' => 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
            'position' => 'body_end',
            'sort_order' => 50,
        ]);

        // Placeholder generic icon pack (kalau AI pakai logical_key "custom-icons")
        HtmlAsset::create([
            'name' => 'Custom Icons Placeholder',
            'logical_key' => 'custom-icons',
            'library' => 'global',
            'type' => 'css',
            'url' => '#', // ganti kalau sudah punya
            'position' => 'head',
            'sort_order' => 60,
        ]);

        // Placeholder generic slider (logical_key "custom-slider")
        HtmlAsset::create([
            'name' => 'Custom Slider Placeholder',
            'logical_key' => 'custom-slider',
            'library' => 'global',
            'type' => 'js',
            'url' => '#', // ganti kalau sudah punya
            'position' => 'body_end',
            'sort_order' => 61,
        ]);

        // Asset 2: Great Vibes
        HtmlAsset::create([
            'name' => 'Google Fonts Great Vibes',
            'logical_key' => 'google-fonts-great-vibes',
            'library' => 'global',
            'type' => 'css',
            'url' => 'https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap',
            'position' => 'head',
            'sort_order' => 2,
        ]);

        // Asset 3: Dancing Script
        HtmlAsset::create([
            'name' => 'Google Fonts Dancing Script',
            'logical_key' => 'google-fonts-dancing-script',
            'library' => 'global',
            'type' => 'css',
            'url' => 'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap',
            'position' => 'head',
            'sort_order' => 3,
        ]);

        // Asset 4: Open Sans
        HtmlAsset::create([
            'name' => 'Google Fonts Open Sans',
            'logical_key' => 'google-fonts-open-sans',
            'library' => 'global',
            'type' => 'css',
            'url' => 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap',
            'position' => 'head',
            'sort_order' => 4,
        ]);

        // Asset 5: Playfair Display
        HtmlAsset::create([
            'name' => 'Google Fonts Playfair Display',
            'logical_key' => 'google-fonts-playfair-display',
            'library' => 'global',
            'type' => 'css',
            'url' => 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap',
            'position' => 'head',
            'sort_order' => 5,
        ]);
    }
}
