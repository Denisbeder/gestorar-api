<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('code');
            $table->enum('status', ['pending', 'expired', 'in_progress', 'approved', 'declined', 'cancelled', 'completed'])->default('pending');
            $table->date('date');
            $table->date('validity')->nullable();
            $table->decimal('extra', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->longText('description')->nullable();
            $table->string('extra_description')->nullable();
            $table->string('discount_description')->nullable();
            $table->json('services');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
