<?php
/**
 *
 * @author - Md. Atiqur Rahman
 * @email - atiqur.su@gmail.com
 * @created - 16/7/22 - 2:24 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */


namespace Atiqsu\WpPave\Http;

use Atiqsu\WpPave\System\Application;

abstract class Controller {

	protected ?Application $app = null;
	protected $request = null;
	protected $response = null;

	public function __construct() {
		$this->app = Application::getInstance();
		//$this->request = $this->app->get('wprequest');
		//$this->response = $this->app->get('wpresponse');
	}

}
