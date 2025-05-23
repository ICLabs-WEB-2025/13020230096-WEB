<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('jadwals', function (Blueprint $table) {
        $table->foreignId('pengajar_id')->nullable()->constrained('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('jadwals', function (Blueprint $table) {
        $table->dropForeign(['pengajar_id']);
        $table->dropColumn('pengajar_id');
    });
}

};
