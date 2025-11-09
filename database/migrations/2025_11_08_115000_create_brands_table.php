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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('place')->nullable();
            $table->string('brand_image');
            $table->string('monday')->nullable()->default('Close');
            $table->string('tuesday')->nullable()->default('Close');
            $table->string('wednesday')->nullable()->default('Close');
            $table->string('thursday')->nullable()->default('Close');
            $table->string('friday')->nullable()->default('Close');
            $table->string('saturday')->nullable()->default('Close');
            $table->string('sunday')->nullable()->default('Close');
            $table->text('address')->nullable();
            $table->text('google_map')->nullable();
            $table->string('phone_number_1')->nullable();
            $table->string('phone_number_2')->nullable();
            $table->boolean('order_valid_status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
