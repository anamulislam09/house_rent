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
        Schema::create('rental_agreements', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('auth_id')->nullable();
            $table->integer('tenant_id');
            $table->integer('building_id'); 
            $table->double('advanced',20, 2)->default(0); 
            $table->string('created_date');
            $table->string('from_date');
            $table->string('to_date');
            $table->string('duration');
            $table->string('notice_period');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_agreements');
    }
};
