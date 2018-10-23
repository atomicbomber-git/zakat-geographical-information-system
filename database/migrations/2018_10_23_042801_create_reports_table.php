<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');

            $table->date('transaction_date');
            
            $table->integer('collector_id')->unsigned();

            $table->decimal('zakat', 19, 4);
            $table->decimal('fitrah', 19, 4);
            $table->decimal('infak', 19, 4);

            $table->text('note');
            
            $table->foreign('collector_id')->references('id')->on('collectors');

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
        Schema::dropIfExists('reports');
    }
}
