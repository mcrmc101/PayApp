<?php namespace Mcrmc\Payapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMcrmcPayappContact extends Migration
{
    public function up()
    {
        Schema::create('mcrmc_payapp_contact', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('cemail')->nullable();
            $table->string('cename')->nullable();
            $table->text('message')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mcrmc_payapp_contact');
    }
}
