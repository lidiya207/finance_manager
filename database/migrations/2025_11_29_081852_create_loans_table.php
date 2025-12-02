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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['given', 'taken']);
            $table->string('person_name');
            $table->string('person_contact')->nullable();
            $table->string('reason')->nullable();

            $table->decimal('principal_amount', 12, 2);
            $table->decimal('outstanding_balance', 12, 2);
            $table->string('currency');

            $table->foreignId('bank_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['open', 'closed'])->default('open');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
