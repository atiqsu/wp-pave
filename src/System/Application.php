<?php

namespace Atiqsu\WpPave\System;

use Atiqsu\WpPave\Container\Container;
use Atiqsu\WpPave\Handlers\EnqueueHandler;
use Atiqsu\WpPave\Http\Page;
use Atiqsu\WpPave\Pages\AdminController;
use Atiqsu\WpPave\Providers\AdminNoticeService;

/**
 * What the f** this is ? - Well right now it's not DI container ......
 *
 */
class Application {

	private static ?Application $instance = null;

	private array $providersInstance = [];

	protected Container $container;

	protected string $version = '1.0.0';

	protected string $path;

	private string $tDom;

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

		$this->bootFrameworkProviders();
	}

	public static function getInstance($path = null): Application {

		if(is_null(self::$instance)) {
			self::$instance = new self($path);
		}

		return self::$instance;
	}

	public function setPluginVersion(string $version): Application {
		$this->version = $version;

		return $this;
	}

	public function setTextDomain($dom): Application {
		$this->tDom = $dom;

		return $this;
	}

	private function bootFrameworkProviders() {
		$conf = require_once __DIR__ . '/systemConf.php';

		if(!empty($conf['before_boot_providers'])) {
			foreach($conf['before_boot_providers'] as $item) {
				$this->container->set($item, $item, true);
			}
		}
	}

	/**
	 * @param $name
	 * @return mixed
	 * @throws \Atiqsu\WpPave\Container\ContainerExceptionInterface
	 * @throws \Atiqsu\WpPave\Container\NotFoundExceptionInterface
	 */
	public function get($name) {
		return $this->container->get($name);
	}

	/**
	 *
	 * @return AdminNoticeService
	 * @throws \Atiqsu\WpPave\Container\ContainerExceptionInterface
	 * @throws \Atiqsu\WpPave\Container\NotFoundExceptionInterface
	 */
	public function getAdminNoticeService(): AdminNoticeService {
		return $this->container->get(AdminNoticeService::class);
	}

	public function init() {

		//$this->container->register(EnqueueHandler::class);
		$this->container->register('enqueueService', EnqueueHandler::class);
		$this->container->register('adminPageService', Page::class);


		add_action($this->tDom . '/on/framework/initiated', [$this, 'systemActions']);
	}

	/**
	 * @return void
	 * @throws \Atiqsu\WpPave\Container\ContainerExceptionInterface
	 * @throws \Atiqsu\WpPave\Container\NotFoundExceptionInterface
	 */
	public function systemActions() {

		//$page = $this->get('adminPageService');
		$page = new Page();
		$page->new('urc_admin/one')
			->menuTitle('Wow 1')
			->pageTitle('This is wow ...')
			->caller(AdminController::class)
			->register();

		add_action( 'admin_menu',  [$page, 'init']);

		echo 'Hello world from framework...............initiated ';
	}
}
