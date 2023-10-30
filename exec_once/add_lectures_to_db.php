<?php

use App\Http\Controllers\LectureController;
use App\Models\Lecture;

$lecture_names = file('/home/ec2-user/environment/webapp/python/database/4.text_classes_v4.txt', FILE_IGNORE_NEW_LINES);

foreach ($lecture_names as $lecture_name) {
    Lecture::create(['name' => $lecture_name]);
}
