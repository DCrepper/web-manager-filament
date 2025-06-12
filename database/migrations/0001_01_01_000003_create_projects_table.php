<?php

declare(strict_types=1);

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
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->string('company_name');
            $table->string('website_url');
            $table->text('hosting_info')->nullable();
            $table->date('last_update_date')->nullable();
            $table->date('next_update_date');
            $table->enum('update_frequency', ['heti', 'kétheti', 'havi', 'negyedéves', 'igény szerint'])->nullable();
            $table->boolean('contract_status')->default(false);
            $table->decimal('contract_amount', 10, 2)->nullable();
            $table->string('currency', 3)->default('HUF');
            $table->text('notes')->nullable();
            $table->json('upsell_categories')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
