<?php

function createPwaIcon($size, $filename) {
    $img = imagecreatetruecolor($size, $size);
    imagesavealpha($img, true);
    
    // Background Dark Slate
    $bg = imagecolorallocate($img, 17, 18, 16);
    imagefill($img, 0, 0, $bg);
    
    // Terracotta Orange Accent circle
    $accent = imagecolorallocate($img, 226, 112, 78);
    $white = imagecolorallocate($img, 255, 255, 255);
    
    // Pin Center
    $cx = $size / 2;
    $cy = (int)($size * 0.42);
    $r = (int)($size * 0.28);
    imagefilledellipse($img, $cx, $cy, $r * 2, $r * 2, $accent);
    
    // Triangle base of pin
    $points = [
        (int)($cx - $r * 0.85), (int)($cy + $r * 0.4),
        $cx, (int)($size * 0.76),
        (int)($cx + $r * 0.85), (int)($cy + $r * 0.4)
    ];
    imagefilledpolygon($img, $points, 3, $accent);
    
    // White bag
    $bw = (int)($size * 0.24);
    $bh = (int)($size * 0.22);
    imagefilledrectangle($img, (int)($cx - $bw/2), (int)($cy - $bh/3), (int)($cx + $bw/2), (int)($cy + $bh/1.5), $white);
    
    // Inner dot
    imagefilledellipse($img, $cx, $cy + (int)($bh * 0.15), (int)($size * 0.06), (int)($size * 0.06), $accent);
    
    imagepng($img, $filename);
    imagedestroy($img);
}

if (extension_loaded('gd')) {
    createPwaIcon(192, __DIR__ . '/icon-192.png');
    createPwaIcon(512, __DIR__ . '/icon-512.png');
    createPwaIcon(180, __DIR__ . '/apple-touch-icon.png');
    echo "PNG Icons generated successfully via GD!" . PHP_EOL;
} else {
    echo "GD not loaded, SVG will be used." . PHP_EOL;
}
