<?php

declare(strict_types=1);

use App\Models\MarketingCategory;
use App\Models\Project;
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
        Schema::create('marketings', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Project::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(MarketingCategory::class)->constrained()->onDelete('cascade');
            $table->integer('monthly_management_fee')->nullable();
            $table->integer('advertising_cost')->nullable();
            $table->enum('advertising_payer', ['client', 'cegem360'])->nullable();
            $table->string('post_frequency')->nullable();
            $table->text('notes')->nullable();
            $table->date('order_date')->nullable();
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketings');
    }
};
