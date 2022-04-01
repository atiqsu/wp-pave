<?php
/**
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 30/3/22 - 12:02 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Contracts\EnqueueInterface;
use Atiqsu\WpPave\System\Application;

/**
 * wp_register_script( string $handle, string|bool $src, string[] $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 * wp_enqueue_script( string $handle, string $src = '', string[] $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 31/3/22 - 11:59 AM
 *
 * Package - Atiqsu\WpPave\Handlers
 * ScriptHandler is responsible for
 *
 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
 */
class ScriptHandler implements EnqueueInterface {

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var string
	 */
	private string $handle;

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var array
	 */
	private array $deps = [];

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var bool
	 */
	private bool $isInFooter = true;

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var string
	 */
	private string $flName;

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var string|null
	 */
	private ?string $changePath = '';

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var string
	 */
	private string $version;

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var string
	 */
	private string $objName;

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var bool
	 */
	private bool $hasLocal = false;

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var array
	 */
	private array $local;


	/**
	 * getHandle is a getter for the $handle variable.
	 *
	 * @return string
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 30/3/22 - 4:56 PM
	 *
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 */
	public function getHandle(): string {
		return $this->handle;
	}

	/**
	 * setHandle is responsible for doing some .
	 *
	 * @param string $handle
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return $this
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 1/4/22 - 11:58 AM
	 *
	 */
	public function setHandle(string $handle): ScriptHandler {
		$this->handle = $handle;

		return $this;
	}

	/**
	 * setDeps is responsible for doing some .
	 *
	 * @param array $arr
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return $this
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 30/3/22 - 4:34 PM
	 *
	 */
	public function setDeps(array $arr): ScriptHandler {
		$this->deps = $arr;

		return $this;
	}

	/**
	 * inFooter is responsible for doing some .
	 *
	 * @param $newVal
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return $this
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 1/4/22 - 11:59 AM
	 *
	 */
	public function inFooter($newVal = true): ScriptHandler {
		$this->isInFooter = $newVal;

		return $this;
	}

	/**
	 * file is responsible for doing some .
	 *
	 * @param $fileName
	 * @param $changeRelPath
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return $this
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 30/3/22 - 4:43 PM
	 *
	 */
	public function file(string $fileName, ?string $changeRelPath = ''): ScriptHandler {
		$this->flName     = $fileName;
		$this->changePath = $changeRelPath;

		return $this;
	}

	/**
	 * changeVersion is responsible for doing some .
	 *
	 * @param $version
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return $this
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 30/3/22 - 4:49 PM
	 *
	 */
	public function changeVersion($version): ScriptHandler {
		$this->version = $version;

		return $this;
	}

	/**
	 * localize is responsible for doing some .
	 *
	 * @param string $objName
	 * @param array $val
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return $this
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 1/4/22 - 12:00 PM
	 *
	 */
	public function localize(string $objName, array $val): ScriptHandler {

		$this->objName  = $objName;
		$this->hasLocal = true;
		$this->local    = $val;

		return $this;
	}

	/**
	 * call is responsible for doing some .
	 *
	 * @return bool
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 1/4/22 - 12:00 PM
	 *
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 */
	public function call(): bool {
		$app = Application::getInstance();

		$this->version = $this->version ?? $app->getVersion();

		$loc = $app->getJsUrl() . $this->flName;

		if(!empty($this->changePath)) {
			$loc = $app->getBaseUrl() . $this->changePath . $this->flName;
		}

		wp_register_script($this->handle, $loc, $this->deps, $this->version, $this->isInFooter);

//		if($this->hasLocal) {
//			wp_localize_script($this->handle, $this->objName, $this->local);
//		}

		return true;
	}

	/**
	 * hasMeetTheCondition is responsible for doing some .
	 *
	 * @param Application $sys
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 * @return bool
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 31/3/22 - 11:58 AM
	 *
	 */
	private function hasMeetTheCondition(Application $sys): bool {

		return true;
	}

	public function init(Application $application) {

		if($this->hasMeetTheCondition($application)) {

			wp_enqueue_script($this->handle);

			if($this->hasLocal) {
				wp_localize_script($this->handle, $this->objName, $this->local);
			}
		}
	}
}

# end of file cache - TWQuIEF0aXF1ciBSYWhtYW4#
