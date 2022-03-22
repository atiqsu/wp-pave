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

	public function set(string $id, $val, $singleton = true) {
		$key = $this->makeKey($id);

		if($singleton === true) {
			$this->singletons[$key] = true;
		}

		if ($val instanceof \Closure) {
			throw new DependencyResolutionException('For the time being we are not allowing closure.');
		}
	}

	public function buildObject(string $name) {
		$key = $this->makeKey($name);
		$className = $this->resolveAlias($name);

		try {
			$reflection = new \ReflectionClass($className);

		} catch(\ReflectionException $ex) {
			throw new DependencyResolutionException(
				sprintf('From reflection: cannot autowire due to "%s".', $ex->getMessage())
			);
		}

		$constructor = $reflection->getConstructor(); // $constructor === null ? new $key(): ''

		if($constructor === null) {
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
}
