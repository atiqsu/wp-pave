<?php
/**
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 4/4/22 - 12:56 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */

namespace Atiqsu\WpPave\Contracts;

interface MiddlewareInterface {

	public function verify(\WP_REST_Request $request) : bool;

}
