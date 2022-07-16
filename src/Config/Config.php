<?php

namespace Atiqsu\WpPave\Config;

use Atiqsu\WpPave\System\Application;

class Config implements ConfigInterface {

	private array $bucket = [];

	public static function get($key, $def = null) {
		$ins = self::getInstance();

		return $ins->has($key) ? $ins->bucket[$key] : $def;
	}

	public static function set($key, $val) {
		self::getInstance()->bucket[$key] = $val;

		return true;
	}

	public function setVal($key, $val) {
		$this->bucket[$key] = $val;
	}

	/**
	 * has is responsible for doing some .
	 *
	 * @param string $key
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return bool
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 6/4/22 - 3:23 PM
	 *
	 */
	private function has(string $key): bool {
		return isset($this->bucket[$key]);
	}

	/**
	 * getInstance is responsible for doing some .
	 *
	 * @return Config
	 * @throws \Atiqsu\WpPave\Container\ContainerExceptionInterface
	 * @throws \Atiqsu\WpPave\Container\NotFoundExceptionInterface
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 6/4/22 - 3:23 PM
	 *
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 */
	protected static function getInstance(): Config {
		return Application::getInstance()->getContainer()->resolve(Config::class);
	}
}
