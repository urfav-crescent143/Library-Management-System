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
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id') //This connects the Fine to the exact borrowing.
                  ->constrained('borrowings') //tells Laravel that this ID comes from the borrowings table.
                  ->onDelete('cascade');
            $table->integer('overdue_days'); //we know how many days late the book was
            $table->decimal('amount', 8, 2); //stores money safely.The 2 means we keep two decimal places.
            $table->string('status')->default('Unpaid'); //Every new fine automaticallt starts as unpaid. later if the member pays it stated as paid.
            $table->timestamp('paid_at')->nullable(); //This stores when the fine was actually paid.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};