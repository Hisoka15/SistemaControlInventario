<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Measurement\UnitsOfMeasurement;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $unitsMeasurements = UnitsOfMeasurement::$UnitMeasurements;
            $typesMeasurements = array_keys($unitsMeasurements);

            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('unit_of_measurement');
            $table->enum('type_of_measurement', $typesMeasurements);
            $table->decimal('price', 10, 2);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
