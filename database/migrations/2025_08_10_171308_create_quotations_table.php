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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uniqueId');
            $table->foreignId('itinerary_id')->constrained('itineraries')->onDelete('cascade');
            $table->string('title');
            $table->decimal('price_per_person', 10, 2);
            $table->string('currency');
            $table->text('notes')->nullable();
            $table->boolean('is_final');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
