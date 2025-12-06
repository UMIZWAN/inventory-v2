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

        // For Super User to Track Every Usage in system to track bugs
        Schema::create('s_logs', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->timestamps();
        });

        Schema::create('s_group', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('is_active')->nullable();
            $table->timestamps();
        });

        Schema::create('s_tax', function (Blueprint $table) {
            $table->id();
            $table->string('tax_name');
            $table->decimal('tax_percentage', 5, 2);
        });

        Schema::create('s_branch', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('s_group_id')->nullable()->constrained('s_group')->cascadeOnDelete();
            $table->string('is_active')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('email_verified_at');
            $table->unsignedBigInteger('s_accessLevel_id')->nullable()->after('remember_token');
            $table->unsignedBigInteger('s_group_id')->nullable()->after('s_accessLevel_id');
            $table->foreign('s_accessLevel_id')
                ->references('id')
                ->on('s_accessLevel')
                ->cascadeOnDelete();
            $table->foreign('s_group_id')
                ->references('id')
                ->on('s_group')
                ->cascadeOnDelete();
        });

        Schema::create('user_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('s_branch')->cascadeOnDelete();
            $table->string('is_primary')->nullable();
            $table->timestamps();
        });


        Schema::create('s_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('is_active')->nullable();
            $table->timestamps();
        });

        Schema::create('s_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('is_active')->nullable();
            $table->timestamps();
        });

        Schema::create('s_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('s_types_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('is_active')->nullable();
            $table->timestamps();
        });

        Schema::create('s_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('s_types_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('is_active')->nullable();
            $table->timestamps();
        });

        // running no should be unique but because need to enable delete while keeping record so cannot unique
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('running_number');
            $table->string('is_assset')->nullable();
            $table->foreignId('s_group_id')->nullable()->constrained('s_group')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->foreignId('s_type_id')->nullable()->constrained('s_types')->cascadeOnDelete();
            $table->foreignId('s_size_id')->nullable()->constrained('s_sizes')->cascadeOnDelete();
            $table->foreignId('s_category_id')->nullable()->constrained('s_category')->cascadeOnDelete();
            $table->foreignId('s_tag_id')->nullable()->constrained('s_tags')->cascadeOnDelete();
            $table->unsignedInteger('min_quantity')->default(0);
            $table->decimal('purchase_cost', 12, 4)->nullable();
            $table->decimal('sale_price', 12, 4)->nullable();
            $table->string('unit_measure')->nullable();
            $table->string('image_path')->nullable();
            $table->text('remark')->nullable();
            $table->json('action_log')->nullable();
            $table->timestamps();
        });

        Schema::create('item_branch_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('item_branch_id')->constrained('s_branch')->cascadeOnDelete();
            $table->string('asset_rack_no')->nullable();
            $table->unsignedInteger('current_unit')->default(0);
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('office_no')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('is_active')->nullable();
        });

        Schema::create('shipping_option', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('is_active')->nullable();
            $table->timestamps();
        });

        Schema::create('transaction_purpose', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('transaction_type');
            $table->string('is_active')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();

            $table->enum('po_status', ['REQUESTED', 'APPROVED', 'REJECTED', 'COMPLETED'])->default('REQUESTED');

            $table->decimal('po_total_cost', 12, 2)->nullable();
            $table->text('remark')->nullable();

            // Trackers
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });


        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->integer('qty_ordered');
            $table->integer('qty_received')->default(0);
            $table->integer('qty_remaining')->virtualAs('qty_ordered - qty_received');
            $table->decimal('unit_cost', 12, 4)->nullable();
            $table->decimal('total_cost', 12, 4)->nullable();
            $table->timestamps();
        });


        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_running_number')->unique();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->cascadeOnDelete();
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_orders')->nullOnDelete();
            $table->enum('transaction_type', ['IN', 'OUT', 'TRANSFER']);
            $table->string('in_recipient_name')->nullable();
            $table->string('out_recipient_name')->nullable();
            $table->foreignId('shipping_option_id')->nullable()->constrained('shipping_option')->nullOnDelete();

            /*
            IN - 'REQUESTED', 'REJECTED', 'APPROVED', 'RECEIVED'
            OUT - 'IN PROGRESS', 'COMPLETED'
            TRANSFER - 'REQUESTED', 'REJECTED', 'APPROVED', 'IN-TRANSIT', 'TRANSFERRED'
             */
            $table->enum(
                'transaction_status',
                ['REQUESTED', 'REJECTED', 'APPROVED', 'IN-TRANSIT', 'RECEIVED', 'IN PROGRESS', 'COMPLETED', 'TRANSFERRED']
            )->nullable();

            // PURPOSE: allow multiple purposes (JSON)
            $table->foreignId('transaction_purpose_id')->nullable()->constrained('transaction_purpose')->nullOnDelete();

            $table->foreignId('from_branch_id')->nullable()->constrained('s_branch')->cascadeOnDelete();
            $table->foreignId('to_branch_id')->nullable()->constrained('s_branch')->cascadeOnDelete();
            $table->text('transaction_remark')->nullable();
            $table->json('transaction_log')->nullable();
            $table->decimal('transaction_total_cost', 12, 2)->nullable();

            // Trackers
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->nullOnDelete();

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
        });

        Schema::create('transaction_item_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->enum('status', ['REJECTED', 'APPROVED', 'FLOAT', 'RECEIVED', 'RETURNED', 'COMPLETED', 'TRANSFERRED'])->nullable();
            $table->integer('asset_unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_item_list');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('transaction_purpose');
        Schema::dropIfExists('shipping_option');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('item_branch_values');
        Schema::dropIfExists('items');
        Schema::dropIfExists('s_category');
        Schema::dropIfExists('s_sizes');
        Schema::dropIfExists('s_types');
        Schema::dropIfExists('s_tags');
        Schema::dropIfExists('user_branch');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['s_accessLevel_id']);
            $table->dropColumn('s_accessLevel_id');
            $table->dropColumn('username');
        });

        Schema::dropIfExists('s_branch');
        Schema::dropIfExists('s_tax');
        Schema::dropIfExists('s_group');
        Schema::dropIfExists('s_logs');
        Schema::dropIfExists('s_accessLevel');
    }
};
