<?php

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Contracts\EnqueueInterface;
use Atiqsu\WpPave\System\Application;

/**
 * wp_enqueue_style( string $handle, string $src = '', string[] $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_register_style( string $handle, string|bool $src, string[] $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 *
 */
class EnqueueHandler implements \Atiqsu\WpPave\Contracts\EnqueueHandlerInterface {

	private array $scriptList = [];
	private array $styleList = [];
	private array $scripts = [];
	private array $registered = [];

	private string $version;
	private ?EnqueueInterface $object;
	private ?ScriptHandler $script;
	private ?StyleHandler $style;

	public function newScript(string $uniqueHandle) : ScriptHandler {

		$this->object = new ScriptHandler();
		$this->object->setHandle($uniqueHandle);
		$this->scriptList[$uniqueHandle] = $this->object;

		return $this->object;
	}

	public function newStyle(string $uniqueHandle) : StyleHandler {

		$this->object = new StyleHandler();
		$this->object->setHandle($uniqueHandle);
		$this->styleList[$uniqueHandle] = $this->object;

		return $this->object;
	}

	public function register(): bool {

		if($this->object instanceof ScriptHandler) {
			$this->scriptList[$this->object->getHandle()] = $this->object;

		} elseif($this->object instanceof StyleHandler) {
			$this->styleList[$this->object->getHandle()] = $this->object;
		}

		$this->object = null;

		return true;
	}

	public function init(Application $app) {

		foreach($this->styleList as $hdl => $obj) {
			$obj->init($app);
		}

		foreach($this->scriptList as $hdl => $obj) {
			$obj->init($app);
		}
	}



	/**
	 * initScript is responsible for doing some .
	 *
	 * @return bool
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 29/3/22 - 6:07 PM
	 *
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 */



	public function on(string $name = 'admin'): EnqueueHandler {

		return $this;
	}

	public function style($path, $options = []) {
		// TODO: Implement style() method.
	}

	public function inlineStyle($data, $handle = '') {
		// TODO: Implement inlineStyle() method.
	}

	public function script(string $handle) {
		// TODO: Implement script() method.
	}

	public function headerScript($path, $options = []) {
		// TODO: Implement headerScript() method.
	}

	public function footerScript($path, $options = []) {
		// TODO: Implement footerScript() method.
	}

	public function localizeScript($handle, $objectName, $data) {
		// TODO: Implement localizeScript() method.
	}

	public function inlineScript($data, $option = []) {
		// TODO: Implement inlineScript() method.
	}

	/**
	 * newInstance is responsible for doing some .
	 *
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 29/3/22 - 6:10 PM
	 *
	 * @return $this
	 */
	protected function newInstance(): EnqueueHandler {

		/**
		 * To get the new instance of this service
		 *
		 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
		 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
		 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
		 */

		return new static();
	}
}

# end of file cache - TWQuIEF0aXF1ciBSYWhtYW4#
