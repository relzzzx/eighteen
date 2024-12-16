<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booths', function (Blueprint $table) {
            $table->enum('status', ['open', 'closed'])->default('closed')->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('booths', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
