<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('acceptance_id')->constrained('users')->cascadeOnDelete()->nullable();
            $table->enum('status', ['awaiting_verification', 'verified', 'on_repair', 'delayed', 'completed', 'cancelled'])->default('awaiting_verification')->index();
            $table->unsignedDecimal('total_amount', 12, 2)->default(0);
            $table->dateTime('start_date')->index();
            $table->dateTime('end_date')->index();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });

        Schema::create('maintenance_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->string('tool_name');
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maintenances', function (Blueprint $table) {
            //
        });
    }
};
