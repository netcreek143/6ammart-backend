<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Admins
        if (!Schema::hasTable('admins')) {
            Schema::create('admins', function (Blueprint $table) {
                $table->id();
                $table->string('f_name', 100)->nullable();
                $table->string('l_name', 100)->nullable();
                $table->string('phone', 20)->nullable();
                $table->string('email', 100);
                $table->string('image', 100)->nullable();
                $table->string('password', 100);
                $table->rememberToken();
                $table->timestamps();
                $table->unsignedBigInteger('role_id');
                $table->unsignedBigInteger('zone_id')->nullable();
                $table->tinyInteger('is_logged_in')->default(1);
                $table->string('login_remember_token', 255)->nullable();
            });
        }

        // 2. Users (Core columns only, excluding wallet_balance/loyalty_point added by 2022_04_09 legacy files)
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('f_name', 100)->nullable();
                $table->string('l_name', 100)->nullable();
                $table->string('phone', 255)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('image', 100)->nullable();
                $table->tinyInteger('is_phone_verified')->default(0);
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 100)->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->string('interest', 255)->nullable();
                $table->string('cm_firebase_token', 255)->nullable();
                $table->tinyInteger('status')->default(1);
                $table->integer('order_count')->default(0);
                $table->string('login_medium', 255)->nullable();
                $table->string('social_id', 255)->nullable();
                $table->unsignedBigInteger('zone_id')->nullable();
                // Excluded: wallet_balance, loyalty_point, ref_code, current_language_key, ref_by, temp_token, module_ids, etc.
            });
        }

        // 3. Modules (Core columns only, excluding icon/theme_id/description added by 2022_04_21 legacy files)
        if (!Schema::hasTable('modules')) {
            Schema::create('modules', function (Blueprint $table) {
                $table->id();
                $table->string('module_name', 191);
                $table->string('module_type', 191);
                $table->string('thumbnail', 255)->nullable();
                $table->tinyInteger('status')->default(1);
                $table->integer('stores_count')->default(0);
                $table->timestamps();
                // Excluded: icon, theme_id, description, all_zone_service
            });
        }

        // 4. Orders
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->decimal('order_amount', 24, 2)->default(0);
                $table->decimal('coupon_discount_amount', 24, 2)->default(0);
                $table->string('coupon_discount_title', 255)->nullable();
                $table->string('payment_status', 255)->default('unpaid');
                $table->string('order_status', 255)->default('pending');
                $table->decimal('total_tax_amount', 24, 2)->default(0);
                $table->string('payment_method', 30)->nullable();
                $table->string('transaction_reference', 30)->nullable();
                $table->bigInteger('delivery_address_id')->nullable();
                $table->unsignedBigInteger('delivery_man_id')->nullable();
                $table->string('coupon_code', 255)->nullable();
                $table->text('order_note')->nullable();
                $table->string('order_type', 255)->default('delivery');
                $table->tinyInteger('checked')->default(0);
                $table->unsignedBigInteger('store_id')->nullable();
                $table->timestamps();
                $table->decimal('delivery_charge', 24, 2)->default(0);
                $table->timestamp('schedule_at')->nullable();
                $table->string('callback', 255)->nullable();
                $table->string('otp', 255)->nullable();
                $table->timestamp('pending')->nullable();
                $table->timestamp('accepted')->nullable();
                $table->timestamp('confirmed')->nullable();
                $table->timestamp('processing')->nullable();
                $table->timestamp('handover')->nullable();
                $table->timestamp('picked_up')->nullable();
                $table->timestamp('delivered')->nullable();
                $table->timestamp('canceled')->nullable();
                $table->timestamp('refund_requested')->nullable();
                $table->timestamp('refunded')->nullable();
                $table->text('delivery_address')->nullable();
                $table->tinyInteger('scheduled')->default(0);
                $table->decimal('store_discount_amount', 24, 2)->default(0);
                $table->decimal('original_delivery_charge', 24, 2)->default(0);
                $table->timestamp('failed')->nullable();
                $table->decimal('adjusment', 24, 2)->default(0);
                $table->tinyInteger('edited')->default(0);
                $table->string('delivery_time', 255)->nullable();
                $table->unsignedBigInteger('zone_id')->nullable();
                $table->unsignedBigInteger('module_id');
                $table->text('order_attachment')->nullable();
                $table->unsignedBigInteger('parcel_category_id')->nullable();
                $table->longText('receiver_details')->nullable();
                $table->enum('charge_payer', ['sender', 'receiver'])->nullable();
                $table->double('distance', 16, 3)->default(0);
                // Excluded: dm_tips (added by 2022_05_14 migration)
                // Excluded: free_delivery_by (added by 2022_07_31 migration)
                $table->timestamp('refund_request_canceled')->nullable();
                // Excluded: prescription_order, tax_status (added by later migrations)
                $table->unsignedBigInteger('dm_vehicle_id')->nullable();
                $table->string('cancellation_reason', 255)->nullable();
                $table->string('canceled_by', 50)->nullable();
                $table->string('coupon_created_by', 50)->nullable();
                $table->string('discount_on_product_by', 50)->default('vendor');
                $table->string('processing_time', 10)->nullable();
                $table->string('unavailable_item_note', 255)->nullable();
                $table->tinyInteger('cutlery')->default(0);
                $table->text('delivery_instruction')->nullable();
                $table->double('tax_percentage', 24, 3)->nullable();
                $table->double('additional_charge', 23, 3)->default(0);
                $table->text('order_proof')->nullable();
                $table->double('partially_paid_amount', 23, 3)->default(0);
                $table->tinyInteger('is_guest')->default(0);
                $table->double('flash_admin_discount_amount', 24, 3)->default(0);
                $table->double('flash_store_discount_amount', 24, 3)->default(0);
                $table->unsignedBigInteger('cash_back_id')->nullable();
                $table->double('extra_packaging_amount', 23, 3)->default(0);
                $table->double('ref_bonus_amount', 23, 3)->default(0);
                $table->string('tax_type', 255)->nullable();
                $table->integer('bring_change_amount')->default(0);
                $table->text('cancellation_note')->nullable();
            });
        }

        // 5. Vendors
        if (!Schema::hasTable('vendors')) {
            Schema::create('vendors', function (Blueprint $table) {
                $table->id();
                $table->string('f_name', 100);
                $table->string('l_name', 100)->nullable();
                $table->string('phone', 20);
                $table->string('email', 100);
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 100);
                $table->rememberToken();
                $table->timestamps();
                $table->text('rejection_note')->nullable();
                $table->string('branch', 255)->nullable();
                $table->string('holder_name', 255)->nullable();
                $table->string('account_no', 255)->nullable();
                $table->string('image', 255)->nullable();
                $table->tinyInteger('status')->default(1);
                $table->string('firebase_token', 255)->nullable();
                $table->string('auth_token', 255)->nullable();
                $table->string('login_remember_token', 255)->nullable();
            });
        }

        // 6. Brands
        if (!Schema::hasTable('brands')) {
            Schema::create('brands', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('slug', 255)->nullable();
                $table->string('image', 100)->nullable();
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
                $table->unsignedBigInteger('module_id')->nullable();
            });
        }

        // 7. Order Transactions
        if (!Schema::hasTable('order_transactions')) {
            Schema::create('order_transactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('vendor_id')->nullable();
                $table->unsignedBigInteger('delivery_man_id')->nullable();
                $table->unsignedBigInteger('order_id');
                $table->decimal('order_amount', 24, 2);
                $table->decimal('store_amount', 24, 2)->default(0);
                $table->decimal('admin_commission', 24, 2);
                $table->string('received_by', 255);
                $table->string('status', 255)->nullable();
                $table->timestamps();
                $table->decimal('delivery_charge', 24, 2)->default(0);
                $table->decimal('original_delivery_charge', 24, 2)->default(0);
                $table->decimal('tax', 24, 2)->default(0);
                $table->unsignedBigInteger('zone_id')->nullable();
                $table->unsignedBigInteger('module_id');
                $table->unsignedBigInteger('parcel_catgory_id')->nullable();
                // Excluded: dm_tips (added by 2022_05_14 migration)
                $table->double('delivery_fee_comission', 24, 2)->default(0);
                $table->decimal('admin_expense', 23, 3)->default(0);
                $table->double('store_expense', 23, 3)->default(0);
                $table->double('discount_amount_by_store', 23, 3)->default(0);
                $table->double('additional_charge', 23, 3)->default(0);
                // Excluded: extra_packaging_amount, ref_bonus_amount
                $table->double('commission_percentage', 16, 3)->default(0);
                $table->tinyInteger('is_subscribed')->default(0);
            });
        }

        // 8. User Notifications
        if (!Schema::hasTable('user_notifications')) {
            Schema::create('user_notifications', function (Blueprint $table) {
                $table->id();
                $table->text('data')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('vendor_id')->nullable();
                $table->unsignedBigInteger('delivery_man_id')->nullable();
                $table->timestamps();
            });
        }

        // 9. Parcel Categories
        if (!Schema::hasTable('parcel_categories')) {
            Schema::create('parcel_categories', function (Blueprint $table) {
                $table->id();
                $table->string('image', 191)->nullable();
                $table->string('name', 191);
                $table->text('description');
                $table->tinyInteger('status')->default(1);
                $table->integer('orders_count')->default(0);
                $table->unsignedBigInteger('module_id');
                $table->timestamps();
                $table->double('parcel_per_km_shipping_charge', 23, 2)->nullable();
                $table->double('parcel_minimum_shipping_charge', 23, 2)->nullable();
            });
        }

        // 10. Banners
        if (!Schema::hasTable('banners')) {
            Schema::create('banners', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255)->nullable();
                $table->string('type', 255);
                $table->string('image', 255)->nullable();
                $table->tinyInteger('status')->default(1);
                $table->string('data', 255);
                $table->timestamps();
                $table->unsignedBigInteger('zone_id');
                $table->unsignedBigInteger('module_id');
                $table->tinyInteger('featured')->default(0);
                $table->string('default_link', 255)->nullable();
                $table->string('created_by', 255)->default('admin');
            });
        }

        // 11. Vendor Employees
        if (!Schema::hasTable('vendor_employees')) {
            Schema::create('vendor_employees', function (Blueprint $table) {
                $table->id();
                $table->string('f_name', 100)->nullable();
                $table->string('l_name', 100)->nullable();
                $table->string('phone', 20)->nullable();
                $table->string('email', 100);
                $table->string('image', 100)->nullable();
                $table->unsignedBigInteger('employee_role_id');
                $table->unsignedBigInteger('vendor_id');
                $table->unsignedBigInteger('store_id');
                $table->string('password', 100);
                $table->tinyInteger('status')->default(1);
                $table->rememberToken();
                $table->string('firebase_token', 255)->nullable();
                $table->string('auth_token', 255)->nullable();
                $table->timestamps();
                $table->tinyInteger('is_logged_in')->default(1);
                $table->string('login_remember_token', 255)->nullable();
            });
        }

        // 12. Add Ons
        if (!Schema::hasTable('add_ons')) {
            Schema::create('add_ons', function (Blueprint $table) {
                $table->id();
                $table->string('name', 191)->nullable();
                $table->decimal('price', 24, 2)->default(0);
                $table->timestamps();
                $table->unsignedBigInteger('store_id');
                $table->tinyInteger('status')->default(1);
                $table->unsignedBigInteger('addon_category_id')->nullable();
            });
        }

        // 13. Wishlists
        if (!Schema::hasTable('wishlists')) {
            Schema::create('wishlists', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('item_id')->nullable();
                $table->timestamps();
                $table->unsignedBigInteger('store_id')->nullable();
            });
        }

        // 14. Module Zone
        if (!Schema::hasTable('module_zone')) {
            Schema::create('module_zone', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('module_id');
                $table->unsignedBigInteger('zone_id');
                $table->double('per_km_shipping_charge', 23, 2)->nullable();
                $table->double('minimum_shipping_charge', 23, 2)->nullable();
                $table->double('maximum_cod_order_amount', 23, 2)->nullable();
                $table->double('maximum_shipping_charge', 23, 2)->nullable();
                $table->enum('delivery_charge_type', ['fixed', 'distance'])->default('distance');
                $table->double('fixed_shipping_charge', 23, 2)->nullable();
            });
        }

        // 15. Customer Addresses
        if (!Schema::hasTable('customer_addresses')) {
            Schema::create('customer_addresses', function (Blueprint $table) {
                $table->id();
                $table->string('address_type', 100);
                $table->string('contact_person_number', 20);
                $table->text('address')->nullable();
                $table->string('latitude', 255)->nullable();
                $table->string('longitude', 255)->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('contact_person_name', 100)->nullable();
                $table->timestamps();
                $table->unsignedBigInteger('zone_id');
                // Excluded: floor, road, house (added by 2022_05_12 migration)
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
        Schema::dropIfExists('module_zone');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('add_ons');
        Schema::dropIfExists('vendor_employees');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('parcel_categories');
        Schema::dropIfExists('user_notifications');
        Schema::dropIfExists('order_transactions');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('users');
        Schema::dropIfExists('admins');
    }
};
