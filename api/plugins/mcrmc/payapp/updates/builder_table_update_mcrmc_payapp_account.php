<?php namespace Mcrmc\Payapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMcrmcPayappAccount extends Migration
{
    public function up()
    {
        Schema::table('mcrmc_payapp_account', function($table)
        {
            $table->boolean('islive')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('mcrmc_payapp_account', function($table)
        {
            $table->dropColumn('islive');
        });
    }
}
