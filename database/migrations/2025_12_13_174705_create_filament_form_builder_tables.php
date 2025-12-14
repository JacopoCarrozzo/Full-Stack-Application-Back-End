<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filament_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('fields')->nullable();
            $table->boolean('permit_guest_entries')->default(true);
            $table->string('redirect_url')->nullable();
            $table->json('notification_emails')->nullable();
            $table->timestamps();
        });

        Schema::create('filament_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filament_form_id')->constrained('filament_forms')->cascadeOnDelete();
            $table->string('name')->default('');
            $table->string('type');
            $table->string('label')->nullable();
            $table->string('hint')->nullable();
            $table->boolean('required')->default(false);
            $table->string('placeholder')->nullable();
            $table->json('options')->nullable();
            $table->json('rules')->nullable();
            $table->json('conditional_logic')->nullable();
            $table->integer('sort_order')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('filament_form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filament_form_id')->constrained('filament_forms')->cascadeOnDelete();
            $table->longText('data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filament_form_submissions');
        Schema::dropIfExists('filament_form_fields');
        Schema::dropIfExists('filament_forms');
    }
};