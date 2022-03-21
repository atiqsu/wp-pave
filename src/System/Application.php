<?php

namespace Atiqsu\WpPave\System;

use Atiqsu\WpPave\Container\Container;

/**
 * What the f** this is ? - Well right now it's not DI container ......
 *
 */
class Application {

	private static Application $instance;

	private array $providersInstance = [];

	protected Container $container;

	protected string $version = '1.0.0';

	protected string $path;

	/*
	 * Just to prevent instantiating it
	 *
	 */
	private function __construct($path) {

		$this->container = new Container();

		$this->path = $path;

		//$this->pluginFile     = $path;
		//$this->basePath       = untrailingslashit(plugin_dir_path($path));
		//$this->pluginBasename = plugin_basename($path);
	}

	public static function getInstance($path = null): Application {

		if(null === self::$instance) {
			self::$instance = new self($path);
		}

		return self::$instance;
	}

	public function setPluginVersion(string $version): Application {
		$this->version = $version;

		return $this;
	}
}
