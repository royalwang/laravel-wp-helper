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
     */
    public function __construct()
    {
        $this->table_prefix = \Config::get('wp-helper.table_prefix');
    }

	/**
     * Return the option_value from wp_options, based on the given option_name.
	 * If no option_value is found, return a fallback, if provided.
	 *
	 * @param $option_name
	 * @param bool $fallback
	 * @return bool
	 */
	public function option($option_name, $fallback = false)
    {
        $option = DB::table($this->table_prefix.'options')->select('option_value')->where('option_name','=',$option_name)->first();
        if ( $option ) {
            return $option->option_value;
        }
	    return $fallback;
    }

}
