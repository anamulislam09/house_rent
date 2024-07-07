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
        Schema::create('collection_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('auth_id');
            $table->integer('agreement_id');
            $table->string('inv_id');
            $table->integer('tenant_id');
            $table->integer('bill_id');
            $table->double('total_rent_collection', 20,2)->default(0);
            $table->string('collection_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_masters');
    }
};
