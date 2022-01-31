<?php namespace Mcrmc\Payapp\Models;

use Model;

/**
 * Model
 */
class Payment extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'mcrmc_payapp_payments';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
