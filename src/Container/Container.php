<?php

namespace Atiqsu\WpPave\Container;

/**
 * A nice simple example is here
 * - https://github.com/adreastrian/wp-fluent/blob/master/libs/viocon/src/Viocon/Container.php
 *
 */
class Container implements ContainerInterface {

	protected array $instance = [];

	protected array $registry = [];

	protected array $singletons = [];

	private array $debug = [];

	private function makeKey(string $id): string {
		return 'ci\\' . $id;
	}

	public function get(string $id) {
		$key = $this->makeKey($id);

		if(isset($this->instance[$key])) {
			return $this->instance[$key];
		}

		throw new NotFoundException(sprintf("Resource '%s' has not been registered with the container.", $id));
	}

	/**
	 * @inheritDoc
	 */
	public function has(string $id): bool {
		$key = $this->makeKey($id);

		return isset($this->instance[$key]);
	}

	public function set(string $id, $val, bool $singleton = true) {
		$key = $this->makeKey($id);

		if(isset($this->registry[$key])) {
			throw new DependencyResolutionException('Duplicate key. A service is already registered with the given key.');
		}

		if($singleton === true) {
			$this->singletons[$key] = true;
		}

		if ($val instanceof \Closure) {
			throw new DependencyResolutionException('For the time being we are not allowing closure.');
		}

		$primitive = [
			'integer',
			'double',
			'NULL',
			'null',
			'object',
		];

		$typ = gettype($val);
		$this->registry[$key] = $singleton;

		if(in_array($typ, $primitive)) {
			$this->instance[$key] = $val;

			return;
		}

		if(class_exists($val)) {
			$this->debug[] = 'class found: '. $val;
			$this->buildObject($key, $val);
		} else {
			$this->debug[] = 'class not found: '. $val;
		}
	}

	/**
	 * In this function we are hoping to get full qualified class name in string format
	 *
	 * @param string $key
	 * @param $name
	 * @return void
	 */
	private function buildObject(string $key, $name) {

		/**
		 * class_exists
		 * get_class
		 * class_alias
		 * (new ReflectionClass($class))->name;
		 * get_declared_classes
		 * get_defined_functions
		 * get_declared_interfaces
		 * interface_exists
		 * method_exists
		 * is_callable
		 * __invoke
		 * __callStatic
		 * trait_exists
		 *
		 *
		 */

		$className = $this->resolveAlias($name);

		try {
			$reflection = new \ReflectionClass($className);

		} catch(\ReflectionException $ex) {
			throw new DependencyResolutionException(
				sprintf('From reflection: cannot autowire due to "%s".', $ex->getMessage())
			);
		}

		$constructor = $reflection->getConstructor(); // $constructor === null ? new $key(): ''

		/**
		 * Do you know -
		 * $var === null and $var === NULL is not same !!! wt.....
		 */
		if(is_null($constructor)) {
			// There is no constructor, just return a new object.
			$this->instance[$key] = new $className;
		}
		$params = $constructor->getParameters();

		if(count($params) < 1) {
			$this->instance[$key] = new $className;

		} else {
			throw new DependencyResolutionException(
				sprintf('For the time being we are only allowing constructor with zero dependency, found : %d ".', count($params))
			);
		}

		//foreach ($constructor->getParameters() as $param){}
	}

	private function resolveAlias(string $name): string {
		return $name;
	}

	public function dumpDebugLog() {

		echo '<pre>';
		print_r($this->debug);
		echo '</pre>';
	}
}
