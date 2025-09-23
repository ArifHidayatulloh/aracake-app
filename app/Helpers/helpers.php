<?php

if (!function_exists('hexToRgba')) {
    /**
     * Mengubah kode warna HEX menjadi RGBA.
     *
     * @param string $hex   Kode warna hex (e.g., '#RRGGBB' atau '#RGB').
     * @param float  $alpha Tingkat transparansi (0.0 s.d. 1.0).
     * @return string       String warna RGBA.
     */
    function hexToRgba(string $hex, float $alpha = 0.15): string
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return "rgba($r, $g, $b, $alpha)";
    }
}

// Anda bisa menambahkan fungsi-fungsi lain di sini...
if (!function_exists('formatRupiah')) {
    function formatRupiah($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

