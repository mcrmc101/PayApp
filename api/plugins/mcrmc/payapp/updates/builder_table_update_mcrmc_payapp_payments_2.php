<?php namespace Mcrmc\Payapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMcrmcPayappPayments2 extends Migration
{
    public function up()
    {
        Schema::table('mcrmc_payapp_payments', function($table)
        {
            $table->renameColumn('payhash', 'paycode');
        });
    }
    
    public function down()
    {
        Schema::table('mcrmc_payapp_payments', function($table)
        {
            $table->renameColumn('paycode', 'payhash');
        });
    }
}
