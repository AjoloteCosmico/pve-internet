<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::create('email_tracking', function (Blueprint $table) {
            $table->id();
            $table->integer('email_id'); // Identificador único por correo
            $table->string('recipient_email')->nullable();
            $table->timestamp('sended_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_tracking');
    }
};
