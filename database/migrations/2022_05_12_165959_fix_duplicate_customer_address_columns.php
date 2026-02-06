<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixDuplicateCustomerAddressColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            if (Schema::hasColumn('customer_addresses', 'floor')) {
                $table->dropColumn('floor');
            }
            if (Schema::hasColumn('customer_addresses', 'road')) {
                $table->dropColumn('road');
            }
            if (Schema::hasColumn('customer_addresses', 'house')) {
                $table->dropColumn('house');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No reverse needed as these will be re-added by the next migration
    }
}
