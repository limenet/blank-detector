<?php

require 'vendor/autoload.php';

use League\ColorExtractor\Palette;

$root = 'C:\Users\Linus\Dropbox\_IO\PhotoSync';

check($root);

function check($dir)
{
    foreach (glob($dir.'/*') as $file) {
        var_dump($file);
        if (is_dir($file)) {
            check($file);
        } elseif (getimagesize($file)) {
            $palette = Palette::fromFilename($file);

            foreach ($palette->getMostUsedColors(1) as $k => $v) {
                if (dechex($k) === 'ffffff') {
                    $d = getimagesize($file);
                    $percentage = $v / ($d[0] * $d[1]);
                    $threshold = 0.05;
                    if ($percentage > $threshold) {
                        $exif = exif_read_data($file);
                        echo $file.' @ '.($exif['DateTimeOriginal'] ?: '').PHP_EOL;
                    }
                }
            }
        }
    }
}
