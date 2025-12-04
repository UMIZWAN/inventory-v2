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
        Schema::create('s_accessLevel', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Role 
            $table->boolean('add_edit_role')->default(false);
            $table->boolean('view_role')->default(false);
            // User
            $table->boolean('add_edit_user')->default(false);
            $table->boolean('view_user')->default(false);
            // Asset
            $table->boolean('add_edit_asset')->default(false);
            $table->boolean('view_asset')->default(false);
            $table->boolean('view_asset_masterlist')->default(false);
            // Branch
            $table->boolean('add_edit_branch')->default(false);
            $table->boolean('view_branch')->default(false);
            // Transaction
            $table->boolean('add_edit_transaction')->default(false);
            $table->boolean('view_transaction')->default(false);
            $table->boolean('approve_reject_transaction')->default(false);
            $table->boolean('receive_transaction')->default(false);
            // Purchase Order
            $table->boolean('add_edit_purchase_order')->default(false);
            $table->boolean('view_purchase_order')->default(false);
            // Supplier
            $table->boolean('add_edit_supplier')->default(false);
            $table->boolean('view_supplier')->default(false);
            // Tax
            $table->boolean('add_edit_tax')->default(false);
            $table->boolean('view_tax')->default(false);
            // Reports
            $table->boolean('view_reports')->default(false);
            $table->boolean('download_reports')->default(false);
            $table->timestamps();
        });

        Schema::create('s_branch', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('is_active')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable();
            $table->unsignedBigInteger('s_accessLevel_id')->nullable();
            $table->foreign('s_accessLevel_id')
                ->references('id')
                ->on('s_accessLevel')
                ->cascadeOnDelete();
        });

        Schema::create('assets_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 's_accessLevel_id')) {
                $table->dropForeign(['s_accessLevel_id']);
                $table->dropColumn('s_accessLevel_id');
                $table->dropColumn('username');
            }
        });
        Schema::dropIfExists('s_branch');
        Schema::dropIfExists('s_accessLevel');
    }
};
