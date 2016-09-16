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
	 * Local copy of retrieved postmeta data, to prevent unnecessary database calls.
	 *
	 * @var array
	 */
	protected $postmeta = false;

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
	 * Return the meta_value from wp_postmeta, based on the given post_id and meta_key.
	 * If no meta_value is found, return a fallback, if provided.
	 *
	 * @param $post_id
	 * @param $meta_key
	 * @param bool $fallback
	 * @return bool
	 */
	public function postmeta($post_id, $meta_key, $fallback = false)
	{
		if ( isset($this->postmeta[$post_id]) ) {
			if ( $this->postmeta[$post_id]->where('meta_key','=',$meta_key)->first() ) {
				return $this->postmeta[$post_id]->where('meta_key','=',$meta_key)->first()->meta_value;
			}
		}
		elseif ( isset($this->postmeta['all']) ) {
			if ( $this->postmeta['all']->where('post_id','=',$post_id)->where('meta_key','=',$meta_key)->first() ) {
				return $this->postmeta['all']->where('post_id','=',$post_id)->where('meta_key','=',$meta_key)->first()->meta_value;
			}
		}
		else {
			$postmeta = DB::table($this->table_prefix.'postmeta')->select('meta_value')->where('post_id','=',$post_id)->where('meta_key','=',$meta_key)->first();
			if ( $postmeta ) {
				return $postmeta->meta_value;
			}
		}
		return $fallback;
	}

	/**
	 * Return all meta keys and values from wp_postmeta.
	 * If a post_id is provided, return only the meta data specific to that post.
	 * Also stores a local copy of the retrieved data for later use.
	 *
	 * @param bool $post_id
	 * @return bool
	 */
	public function allPostmeta($post_id = false)
	{
		if ( $post_id ) {
			if ( !isset($this->postmeta[$post_id]) ) {
				$this->postmeta[$post_id] = DB::table($this->table_prefix.'postmeta')->where('post_id','=',$post_id)->get();
			}
			return $this->postmeta[$post_id];
		}
		else {
			if ( !isset($this->postmeta['all']) ) {
				$this->postmeta['all'] = DB::table($this->table_prefix.'postmeta')->get();
			}
			return $this->postmeta['all'];
		}
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

	/**
	 * Return any page or post by its id, optionally filtered by its post_type.
	 *
	 * @param $id
	 * @param bool $post_type
	 * @return bool
	 */
	public function byId($id, $post_type = false)
	{
		$post = DB::table($this->table_prefix.'posts')
			->where('ID','=',$id)
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
