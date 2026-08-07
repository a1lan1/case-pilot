<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table): void {
            $table->id();
            $table->string('number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status');
            $table->string('priority');
            $table->string('type');

            $table->foreignId('customer_id')->nullable()->index();
            $table->foreignId('assignee_id')->nullable()->index();

            $table->unsignedInteger('version')->default(1);

            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
