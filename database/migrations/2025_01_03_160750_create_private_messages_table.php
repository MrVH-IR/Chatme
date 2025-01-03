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
        Schema::create('private_messages', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('sender_id');
            $table->string('receiver_id');
            $table->string('room_id')->unique();
            $table->timestamps();

            $table->foreign('sender_id')->references('user_id')->on('users');
            $table->foreign('receiver_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_messages');
    }
};
