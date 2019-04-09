<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMuzakkisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muzakkis', function (Blueprint $table) {
            $table->increments('id');

            $table->string("name");
            $table->string("NIK");
            $table->string("kecamatan");
            $table->string("kelurahan");
            $table->string("phone");
            $table->string("gender");
            $table->string("npwz");
            $table->decimal('zakat', 19, 4);
            $table->decimal('fitrah', 19, 4);
            $table->decimal('infak', 19, 4);
            $table->unsignedInteger('collector_id');
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
        Schema::dropIfExists('muzakkis');
    }
}
