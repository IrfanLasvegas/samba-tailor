<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersentasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persentases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bagians_id')->constrained('bagians')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nilai_persentase');
            $table->string('status_persentase');
            $table->string('status_hidden');
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
        Schema::dropIfExists('persentases');
    }
}
