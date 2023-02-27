<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            // add fields
            $table->string('name')->nullable();
            $table->string('type'); // push, web
            $table->string('platform'); // android, apple
            $table->string('token');
            $table->nullableMorphs('notifiable');
            $table->timestamps();

            // add indexes
            $table->index('notifiable_id');
            $table->index('notifiable_type');
            $table->index('type');
        });
    }
};
