<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('logins', function (Blueprint $table) {
            $table->json('used_features')->nullable()->after('country');
        });
    }

    public function down(): void
    {
        Schema::table('logins', function (Blueprint $table) {
            $table->dropColumn('used_features');
        });
    }

};
