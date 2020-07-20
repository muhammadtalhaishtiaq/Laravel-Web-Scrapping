<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebCrawlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_crawler', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('title');
            $table->longText('url');
            $table->string('points');
            $table->string('username');
            $table->string('total_comments');
            $table->string('time_stamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_crawler');
    }
}
