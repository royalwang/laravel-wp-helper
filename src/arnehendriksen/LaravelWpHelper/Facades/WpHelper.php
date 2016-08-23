<?php namespace arnehendriksen\LaravelWpHelper\Facades;

use Illuminate\Support\Facades\Facade;
use arnehendriksen\LaravelWpHelper\WPHelper as WordPressHelper;

class WpHelper extends Facade {

    protected static function getFacadeAccessor() { return WordPressHelper::class; }

}
