<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedCategoriesParentChildRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticketit_categories', function( Blueprint $table ){
            $table->integer('parent')->unsigned()->nullable()->after('id');
            $table->foreign('parent')->references('id')->on('ticketit_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticketit_categories', function( Blueprint $table ){
            $table->dropForeign(['parent']);
            $table->dropColumn(['parent']);
        });
    }
}
