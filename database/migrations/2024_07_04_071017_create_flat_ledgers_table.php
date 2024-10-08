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
        Schema::create('flat_ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('auth_id');
            $table->integer('agreement_id'); 
            $table->integer('tenant_id');
            $table->integer('flat_id'); 
            $table->double('rent',20, 2)->default(0); 
            $table->double('service_charge',20, 2)->default(0); 
            $table->double('utility_bill',20, 2)->default(0); 
            $table->string('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flat_ledgers');
    }
};
