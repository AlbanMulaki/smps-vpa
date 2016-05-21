<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Structure extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('administrata', function($table) {
            $table->increments('id');
            $table->string("emri");
            $table->string("mbiemri");
            $table->boolean('gjinia');
            $table->string("vendlindja");
            $table->string("vendbanimi");
            $table->string("adressa");
            $table->string("shtetas");
            $table->string("telefoni");
            $table->string("email");
            $table->string("nrpersonal");
            $table->string("password");
            $table->integer("xhirollogaria");
            $table->string("avatar");
            $table->string("detyra");
            $table->string("grp");
            $table->string("grada_shkencore");
            $table->string("avatar");
            $table->string("eksperienca");
            $table->string("kualifikimi");
            $table->string("bank_name");
            $table->string("cv");
            $table->string("vpa_registrar");
            $table->string("avatar");
            $table->softDeletes();
            $table->timestamps();
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        DB::table('administrata')->delete();
    }

}
