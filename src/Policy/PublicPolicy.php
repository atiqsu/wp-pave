<?php
/**
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 4/4/22 - 2:55 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */


namespace Atiqsu\WpPave\Policy;

class PublicPolicy extends BasePolicy {

	public function verify(\WP_REST_Request $request): bool {

		return true;
	}


}
