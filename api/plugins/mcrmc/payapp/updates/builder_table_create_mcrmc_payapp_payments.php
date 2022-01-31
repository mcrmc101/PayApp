<?php namespace Mcrmc\Payapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMcrmcPayappPayments extends Migration
{
    public function up()
    {
        Schema::create('mcrmc_payapp_payments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('userid')->nullable();
            $table->text('payhash')->nullable();
            $table->integer('amount')->nullable();
            $table->boolean('ispaid')->default(0);
            $table->string('cemail')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mcrmc_payapp_payments');
    }
}
