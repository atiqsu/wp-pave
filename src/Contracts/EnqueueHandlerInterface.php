<?php
/**
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 30/3/22 - 5:33 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */

namespace Atiqsu\WpPave\Contracts;

use Atiqsu\WpPave\System\Application;

interface EnqueueHandlerInterface {

	/**
	 * script is responsible for doing some .
	 *
	 * @param string $handle
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return mixed
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 31/3/22 - 11:48 AM
	 *
	 */
	public function script(string $handle);

	/**
	 * register is responsible for doing some .
	 *
	 * @return mixed
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 31/3/22 - 12:12 PM
	 *
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 */
	public function register();

	/**
	 * init is responsible for doing some .
	 *
	 * @param Application $app
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return mixed
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 31/3/22 - 11:48 AM
	 *
	 */
	public function init(Application $app);




	/**
	 * Predefined hooks are - admin and front and both
	 *  other possible hooks can be elementor_editor and so on.
	 *
	 * @param string $name - default is admin
	 * @return mixed
	 */
	public function on(string $name = 'admin');

	public function style($path, $options = []);

	public function inlineStyle($data, $handle = '');

	public function headerScript($path, $options = []);

	public function footerScript($path, $options = []);

	public function localizeScript($handle, $objectName, $data);

	public function inlineScript($data, $option = []);


}
