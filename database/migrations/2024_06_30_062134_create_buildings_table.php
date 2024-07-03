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
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('name');
            $table->double('building_rent', 20, 2)->default(0);
            $table->double('service_charge', 20, 2)->default(0);
            $table->double('utility_bill', 20, 2)->default(0);
            $table->string('date');
            $table->string('auth_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
