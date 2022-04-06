<?php
/**
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 4/4/22 - 1:51 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Contracts\HandlerInterface;
use Atiqsu\WpPave\Contracts\RoutingInterface;

class RouterHandler implements RoutingInterface {


	private array $groupStack = [];

	public function group($prefix) {

		$this->groupStack[] = $prefix;
	}

	public function withPolicy($name, $method = null): RouterHandler {

		return $this;
	}
}
