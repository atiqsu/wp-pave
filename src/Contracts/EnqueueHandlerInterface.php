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

use Atiqsu\WpPave\Handlers\EnqueueHandler;
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
	public function newScript(string $handle);

	/**
	 * newStyle is responsible for doing some .
	 *
	 * @param string $uniqueHandle
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return mixed
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 1/4/22 - 3:02 PM
	 *
	 */
	public function newStyle(string $uniqueHandle);

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

	public function inlineStyle($data, $handle = '');

	public function localizeScript($handle, $objectName, $data);

	public function inlineScript($data, $option = []);
}
