<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaJasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_jasas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jasas_id')->constrained('jasas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nominal_harga_jasa');
            $table->string('status_harga_jasa');
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
        Schema::dropIfExists('harga_jasas');
    }
}
