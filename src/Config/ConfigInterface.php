<?php

namespace Atiqsu\WpPave\Config;

interface ConfigInterface {

	public static function get($key, $def = null);

	public static function set($key, $val);
}
