<?php
/* 
Author: Mattias Dahlgren, Mittuniversitetet Sundsvall
Email: Mattias.dahlgren@miun.se
*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            $table->bigInteger('post_id')->unsigned();
            $table->timestamps();
            // relation key
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
