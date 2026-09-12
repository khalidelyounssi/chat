<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cats', function (Blueprint $table): void {
            $table->boolean('is_breeder')->default(false)->index()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('cats', function (Blueprint $table): void {
            $table->dropColumn('is_breeder');
        });
    }
};
