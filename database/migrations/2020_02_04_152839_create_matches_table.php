<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->string('match_id')->nullable();
                    $table->float('ratio')->default(0);
                    $table->float('ior_RH')->default(0);
                    $table->float('ior_RC')->default(0);
                    $table->float('ratio_o')->default(0);
                    $table->float('ratio_u')->default(0);
                    $table->float('ior_OUH')->default(0);
                    $table->float('ior_OUC')->default(0);
                    $table->float('ior_EOO')->default(0);
                    $table->float('ior_EOE')->default(0);
                    $table->float('ratio_ouho')->default(0);
                    $table->float('ratio_ouhu')->default(0);
                    $table->float('ior_OUHO')->default(0);
                    $table->float('ior_OUHU')->default(0);
                    $table->float('ratio_ouco')->default(0);
                    $table->float('ratio_oucu')->default(0);
                    $table->float('ior_OUCO')->default(0);
                    $table->float('ior_OUCU')->default(0);
                        $table->boolean('is_live')->default(0);
                        $table->string('sport_type')->default('basketball');
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
        Schema::dropIfExists('matches');
    }
}
