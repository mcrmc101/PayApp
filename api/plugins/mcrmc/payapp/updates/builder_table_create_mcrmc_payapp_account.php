<?php namespace Mcrmc\Payapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMcrmcPayappAccount extends Migration
{
    public function up()
    {
        Schema::create('mcrmc_payapp_account', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('userid')->nullable();
            $table->string('email')->nullable();
            $table->text('skey')->nullable();
            $table->text('pkey')->nullable();
            $table->text('skey_test')->nullable();
            $table->text('pkey_test')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mcrmc_payapp_account');
    }
}
