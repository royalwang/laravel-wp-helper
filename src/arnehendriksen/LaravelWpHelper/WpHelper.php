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

    /**
     * Return any page or post by its URI, optionally filtered by its post_type.
     *
     * @param $uri
     * @param bool $post_type
     * @return bool
     */
    public function byUri($uri, $post_type = false)
    {
        $post = DB::table($this->table_prefix.'posts')
            ->where('post_name','=',$uri)
            ->where('post_status','=','publish');
        if ( $post_type ) {
            $post = $post->where('post_type','=',$post_type);
        }
        $post = $post->first();
        if ( $post ) {
            return $post;
        }
        return false;
    }

}
