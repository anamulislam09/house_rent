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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('auth_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('nid_no')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->double('balance',20, 2)->default(0); 
            $table->tinyInteger('status')->default(0);
            $table->string('created_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
