<?php namespace Kpolicar\BackendMenuPinnedPages\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePinnedPagesTable Migration
 */
class CreatePinnedPagesTable extends Migration
{
    public function up()
    {
        Schema::create('kpolicar_backendmenupinnedpages_pages', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('label');
            $table->string('path');
            $table->string('icon');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('backend_users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kpolicar_backendmenupinnedpages_pages');
    }
}
