<?php
/**
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 1/4/22 - 4:01 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Contracts\FilterHandlerInterface;

class ActionHandler implements FilterHandlerInterface {

	/**
	 * new is responsible for doing some .
	 *
	 * @param $hook
	 * @param $callback
	 * @param int $priority
	 * @param int $numOfArg
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return mixed
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 1/4/22 - 4:17 PM
	 *
	 */
	protected function new($hook, $callback, int $priority = 10, int $numOfArg = 1) {
		return add_action($hook, $callback, $priority, $numOfArg);
	}

	/**
	 * add is responsible for doing some .
	 *
	 * @param $hook
	 * @param $callback
	 * @param int $priority
	 * @param int $numOfArg
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return void
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 1/4/22 - 4:00 PM
	 *
	 */
	public function add($hook, $callback, int $priority = 10, int $numOfArg = 1) {

		if(function_exists($callback) || is_array($callback) || is_callable($callback)) {
			$this->new($hook, $callback, $priority, $numOfArg);
		}
	}
}
