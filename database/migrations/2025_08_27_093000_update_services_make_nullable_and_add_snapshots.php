<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add temporary columns to safely migrate data without requiring doctrine/dbal
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id_new')->nullable();
            $table->unsignedBigInteger('user_id_new')->nullable();
        });

        // Copy existing values
        DB::statement('UPDATE services SET vehicle_id_new = vehicle_id, user_id_new = user_id');

        // Drop existing foreign keys
        Schema::table('services', function (Blueprint $table) {
            // If constraints exist, drop them
            try {
                $table->dropForeign(['vehicle_id']);
            } catch (\Exception $e) {
                // ignore
            }
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // ignore
            }
        });

        // Drop old columns and recreate as nullable with no cascade
        Schema::table('services', function (Blueprint $table) {
            // drop old columns if they exist
            if (Schema::hasColumn('services', 'vehicle_id')) {
                $table->dropColumn('vehicle_id');
            }
            if (Schema::hasColumn('services', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });

        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
        });

        // Copy data back from temporary columns
        DB::statement('UPDATE services SET vehicle_id = vehicle_id_new, user_id = user_id_new');

        // Drop temporary columns
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'vehicle_id_new')) {
                $table->dropColumn('vehicle_id_new');
            }
            if (Schema::hasColumn('services', 'user_id_new')) {
                $table->dropColumn('user_id_new');
            }
        });

        // Add foreign keys with SET NULL on delete
        Schema::table('services', function (Blueprint $table) {
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Add snapshot columns if not exists
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'license_plate')) {
                $table->string('license_plate', 50)->nullable()->after('photos');
            }
            if (!Schema::hasColumn('services', 'brand')) {
                $table->string('brand')->nullable()->after('license_plate');
            }
            if (!Schema::hasColumn('services', 'model')) {
                $table->string('model')->nullable()->after('brand');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop added snapshot columns
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'model')) {
                $table->dropColumn('model');
            }
            if (Schema::hasColumn('services', 'brand')) {
                $table->dropColumn('brand');
            }
            if (Schema::hasColumn('services', 'license_plate')) {
                $table->dropColumn('license_plate');
            }
        });

        // Remove foreign keys and re-create original behavior: non-null with cascade
        Schema::table('services', function (Blueprint $table) {
            try {
                $table->dropForeign(['vehicle_id']);
            } catch (\Exception $e) {}
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {}
        });

        Schema::table('services', function (Blueprint $table) {
            // make non-nullable again (best effort)
            if (Schema::hasColumn('services', 'vehicle_id')) {
                $table->unsignedBigInteger('vehicle_id')->nullable(false)->change();
            }
            if (Schema::hasColumn('services', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
            }
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
