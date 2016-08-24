<?php namespace arnehendriksen\LaravelWpHelper;

use Illuminate\Support\Facades\DB;

class WpHelper
{

    /**
     * Table prefix as defined in the config.
     *
     * @var string
     */
    protected $table_prefix;

    /**
     * Constructor
     *
     * @param string $table_prefix
     */
    public function __construct()
    {
        $this->table_prefix = \Config::get('wp-helper.table_prefix');
    }

    /**
     * Return the option_value from wp_options, based on the given option_name.
     *
     * @param $option_name
     * @return mixed
     */
    public function option($option_name)
    {
        $option = DB::table($this->table_prefix.'options')->select('option_value')->where('option_name','=',$option_name)->first();
        if ( $option ) {
            return $option->option_value;
        }
    }

}
