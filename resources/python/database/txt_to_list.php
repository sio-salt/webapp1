<?php
$lecture_names = file('4.text_classes_v4.txt', FILE_IGNORE_NEW_LINES);

$i = 0;
foreach ($lecture_names as $name) {
    if ($i % 50 == 0) {
        echo strval($i).' '.$name.PHP_EOL;
    }
    $i = $i + 1;
}
