<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMuzakkiIdFieldToReceivements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivements', function (Blueprint $table) {
            $table->unsignedInteger('muzakki_id')->nullable();
            $table->foreign('muzakki_id')
                ->references('id')
                ->on('muzakkis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivements', function (Blueprint $table) {
            $table->dropForeign(["muzakki_id"]);
            $table->dropColumn("muzakki_id");
        });
    }
}
