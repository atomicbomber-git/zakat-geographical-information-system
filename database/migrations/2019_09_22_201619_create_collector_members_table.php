<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectorMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collector_members', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('collector_id')->comment("id UPZ pada tabel collectors.");
            $table->string("name")->comment("Nama.");
            $table->string("position")->comment("Jabatan.");

            $table->foreign('collector_id')
                ->references('id')
                ->on('collectors');

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
        Schema::dropIfExists('collector_members');
    }
}
