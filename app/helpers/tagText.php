<?php
function tagTextColor(string $colorTop, string $colorBottom): string
{
    if (strlen($colorTop) === 3) {
        $colorTop = $colorTop[0].$colorTop[0].$colorTop[1].$colorTop[1].$colorTop[2].$colorTop[2];
    }
    if (strlen($colorBottom) === 3) {
        $colorBottom = $colorBottom[0].$colorBottom[0].$colorBottom[1].$colorBottom[1].$colorBottom[2].$colorBottom[2];
    }

    $r1 = hexdec(substr($colorTop, 0, 2));
    $g1 = hexdec(substr($colorTop, 2, 2));
    $b1 = hexdec(substr($colorTop, 4, 2));
    $r2 = hexdec(substr($colorBottom, 0, 2));
    $g2 = hexdec(substr($colorBottom, 2, 2));
    $b2 = hexdec(substr($colorBottom, 4, 2));

    $r = ($r1 + $r2) / 2;
    $g = ($g1 + $g2) / 2;
    $b = ($b1 + $b2) / 2;

    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

    return $luminance > 0.5 ? '#1f2937' : '#ffffff';
}