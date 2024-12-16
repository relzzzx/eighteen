<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('order_items', function (Blueprint $table) {
        $table->unsignedBigInteger('booth_id')->after('menu_id');
        $table->foreign('booth_id')->references('id')->on('booths')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('order_items', function (Blueprint $table) {
        $table->dropForeign(['booth_id']);
        $table->dropColumn('booth_id');
    });
}
};
