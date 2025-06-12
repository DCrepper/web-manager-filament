<?php

declare(strict_types=1);

use App\Models\Project;
use App\Models\UpsellCategory;
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
        Schema::create('upsells', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Project::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(UpsellCategory::class)->constrained()->onDelete('cascade');
            $table->string('description')->nullable();
            $table->integer('price')->default(0);
            $table->enum('status', ['Lehetőség', 'Van', 'Később', 'Nem kell'])->default('Lehetőség');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upsells');
    }
};
