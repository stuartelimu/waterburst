<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToBurst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `bursts` MODIFY `filename` VARCHAR(100) NULL;');

        Schema::table('bursts', function (Blueprint $table) {
            // $table->string('filename')->nullabled()->change();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bursts', function (Blueprint $table) {
            $table->string('filename')->nullabled(false)->change();
        });
    }
}
