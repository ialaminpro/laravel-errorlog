<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method_name',45);
            $table->integer('line_number');
            $table->string('file_path',128);
            $table->text('exception_message')->nullable()->default(null);
            $table->string('object',45)->nullable()->default(null);
            $table->string('type',45)->nullable()->default(null);
            $table->string('screenshot',128)->nullable()->default(null);
            $table->string('page_url',256)->nullable()->default(null);
            $table->string('arguments',45)->nullable()->default(null);
            $table->string('prefix',45)->nullable()->default(null);
            $table->string('domain',45)->nullable()->default(null);
            $table->integer('is_resolved')->nullable()->default(null);
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
        Schema::dropIfExists('error_log');
    }
}
