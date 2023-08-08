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
        Schema::create('trello_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trello_group_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('task');
            $table->integer('sort')->default(9999);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trello_cards');
    }
};
