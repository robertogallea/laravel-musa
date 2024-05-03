<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void // invocato quando si lancia la migrazione
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // equivale a $table->unsignedBigInteger('id')->autoIncrementing()->primary()
            $table->string('title', 32);
            $table->text('body');

            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            // equivale a
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users');

            // se non seguo la convenzione sui nomi delle tabelle
            // $table->foreignId('user_id')->constrained(table: 'my_users', indexName: 'posts_users_id');

            $table->boolean('status')->default(false);

            $table->timestamps();
            // equivale a scrivere
            // $table->timestamp('created_at')->nullable();
            // $table->timestamp('updated_at')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void // invocato quando si inverte la migrazione
    {
        Schema::dropIfExists('posts');
    }
};
