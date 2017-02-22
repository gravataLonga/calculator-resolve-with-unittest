<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // id, ip, data_hora, operação, resultado, bonus
        /*
        - id: auto increment 
        - ip: varchar 
        - data_hora: inteiro (nota: unix timestamp timestamp da operação) 
        - operação: varchar (nota: armazenar a operação completa e.g. "1+1/2*5") 
        - resultado: inteiro 
        - bonus: boolean/tinyint (nota: indicar se o resultado da operação acertou no número aleatório) 
         */
        Schema::create('operations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->integer('datetime');
            $table->string('operation');
            $table->decimal('result');
            $table->tinyInteger('bonus')->default(0);
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
        Schema::drop('operations');
    }
}
