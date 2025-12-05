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
        Schema::create('payment_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_reference')->unique();
            $table->string('filename');
            $table->integer('total_records');
            $table->integer('successful_payments')->default(0);
            $table->integer('failed_payments')->default(0);
            $table->integer('pending_payments')->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'partially_completed'])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('created_at');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_batch_id')->constrained()->onDelete('cascade');
            $table->string('beneficiary_name');
            $table->string('beneficiary_id_type'); // MSISDN, PERSONAL_ID, etc.
            $table->string('beneficiary_id_value');
            $table->string('currency', 3)->default('XOF');
            $table->decimal('amount', 10, 2);
            $table->string('home_transaction_id')->unique();
            $table->string('mojaloop_transaction_id')->nullable();
            $table->enum('status', ['pending', 'processing', 'success', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->json('mojaloop_response')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('payment_batch_id');
            $table->index('home_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_batches');
    }
};
