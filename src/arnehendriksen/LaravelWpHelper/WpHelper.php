<?php namespace arnehendriksen\LaravelWpHelper;

class WpHelper
{

    public function __construct()
    {

    }

    /**
     * Return the option_value from wp_options, based on the given option_name.
     *
     * @param $option_name
     * @return mixed
     */
    public function option($option_name) {
        $option = DB::table('wp_options')->select('option_value')->where('option_name','=',$option_name)->first();
        if ( $option ) {
            return $option->option_value;
        }
    }

}
