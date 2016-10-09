<?php

require 'vendor/autoload.php';

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

$root = __DIR__;

foreach (glob($root.'/in/*') as $file) {
    $path = $file;
    $palette = Palette::fromFilename($path);

    foreach ($palette->getMostUsedColors(1) as $k => $v) {
        if(dechex($k) === 'ffffff') {
            $d = getimagesize($path);
            $percentage = $v / ($d[0] * $d[1]);
            $threshold = 0.05;
            if ($percentage > $threshold) {
                $exif = exif_read_data($path);
                echo $path.' @ '.($exif['DateTimeOriginal'] ?? '').PHP_EOL;
            }
        }
    }
}
