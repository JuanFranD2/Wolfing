<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            // Código de la provincia de dos dígitos
            $table->char('cod', 2)->primary()->comment('Código de la provincia de dos digitos');

            // Nombre de la provincia
            $table->string('name', 50)->default('')->comment('Nombre de la provincia');

            // Eliminar la relación con la comunidad autónoma (sin 'comunidad_id' ni clave foránea)
            // $table->tinyInteger('comunidad_id')->unsigned()->comment('Código de la comunidad a la que pertenece');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar la tabla 'provinces'
        Schema::dropIfExists('provinces');
    }
}
