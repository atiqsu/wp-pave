<?php
/**
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 1/4/22 - 3:07 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */

namespace Atiqsu\WpPave\Contracts;

interface FilterHandlerInterface {

	public function add($hook, $callback, int $priority = 10, int $numOfArg = 1);

}
