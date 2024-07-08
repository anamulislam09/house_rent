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
        Schema::create('bill_setups', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('auth_id');
            $table->integer('agreement_id'); 
            $table->string('inv_id')->nullable(); 
            $table->integer('tenant_id');
            $table->integer('flat_id')->nullable();
            $table->double('flat_rent',20, 2)->default(0); 
            $table->double('service_charge',20, 2)->default(0); 
            $table->double('utility_bill',20, 2)->default(0); 
            $table->double('total_current_month_rent',20, 2)->default(0); 
            $table->double('previous_due',20, 2)->default(0); 
            $table->double('total_collection_amount',20, 2)->default(0); 
            $table->double('total_collection',20, 2)->default(0); 
            $table->double('current_due',20, 2)->default(0); 
            $table->string('bill_setup_date')->nullable();
            $table->string('collection_date')->nullable();
            $table->string('created_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_setups');
    }
};
