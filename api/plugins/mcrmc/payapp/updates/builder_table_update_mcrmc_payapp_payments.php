<?php namespace Mcrmc\Payapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMcrmcPayappPayments extends Migration
{
    public function up()
    {
        Schema::table('mcrmc_payapp_payments', function($table)
        {
            $table->string('cname')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('mcrmc_payapp_payments', function($table)
        {
            $table->dropColumn('cname');
        });
    }
}
