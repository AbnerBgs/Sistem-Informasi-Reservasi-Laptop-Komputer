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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->enum('device_type', ['Laptop', 'PC']);
            $table->string('device_brand');
            $table->text('problem_description');
            $table->enum('status', [
                'pending',
                'checking',
                'in_progress',
                'ready',
                'completed',
                'cancelled'
            ])->default('pending');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
