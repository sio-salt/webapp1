<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->string('code')->after('faculty_id');
            $table->string('semester')->after('code');
            $table->string('subject')->after('semester');
            $table->string('teacher')->after('subject');
            $table->string('year')->after('teacher');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropColumn(['code', 'semester', 'subject', 'teacher', 'year']);
        });
    }
};
