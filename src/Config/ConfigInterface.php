<?php

namespace Atiqsu\WpPave\Config;

interface ConfigInterface {

	public static function get($key);

	public static function set($key);
}
