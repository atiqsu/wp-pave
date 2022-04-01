<?php

namespace Atiqsu\WpPave\System;

use Atiqsu\WpPave\Container\Container;
use Atiqsu\WpPave\Handlers\EnqueueHandler;
use Atiqsu\WpPave\Handlers\PageServiceHandler;
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

	protected string $pluginBaseUrl;
	protected string $pluginBaseDir;
	protected string $pluginAppDir;
	protected string $pluginHooksDir;
	protected string $pluginAssetDir;
	protected string $pluginAssetUrl;


	/*
	 * Just to prevent instantiating it
	 *
	 */
	private function __construct($path) {

		$this->container = new Container();

		$this->path = $path;

		$this->pluginBaseUrl  = trailingslashit(plugin_dir_url($path));
		$this->pluginBaseDir  = trailingslashit(plugin_dir_path($path));
		$this->pluginAppDir   = $this->pluginBaseDir . 'app/';
		$this->pluginHooksDir = $this->pluginBaseDir . 'app/Hooks/';
		$this->pluginAssetDir = $this->pluginBaseDir . 'app/assets/';
		$this->pluginAssetUrl = $this->pluginBaseUrl . 'app/assets/';


		//$this->pluginFile     = $path;
		//$this->basePath       = untrailingslashit(plugin_dir_path($path));
		//$this->pluginBasename = plugin_basename($path);

		$this->bootFrameworkMuProviders();
	}

	public static function getInstance($path = null): Application {

		if(is_null(self::$instance)) {
			self::$instance = new self($path);
		}

		return self::$instance;
	}

	public function getBaseUrl(): string {
		return $this->pluginBaseUrl;
	}

	public function getCssDir(): string {
		return $this->pluginAssetDir . 'css/';
	}

	public function getCssUrl(): string {
		return $this->pluginAssetUrl . 'css/';
	}

	public function getJsDir(): string {
		return $this->pluginAssetDir . 'js/';
	}

	public function getJsUrl(): string {
		return $this->pluginAssetUrl . 'js/';
	}

	public function getVersion(): string {

		return $this->version ?? '1.1.' . time();
	}

	public function setPluginVersion(string $version): Application {
		$this->version = $version;

		return $this;
	}

	public function setTextDomain($dom): Application {
		$this->tDom = $dom;

		return $this;
	}

	private function bootFrameworkMuProviders() {
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

	public function has($name): bool {
		return $this->container->has($name);
	}

	public function getContainer(): Container {
		return $this->container;
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

	/**
	 * Shortcut methods
	 *
	 * @return PageServiceHandler
	 * @throws \Atiqsu\WpPave\Container\ContainerExceptionInterface
	 * @throws \Atiqsu\WpPave\Container\NotFoundExceptionInterface
	 */
	public function getPageService(): PageServiceHandler {
		return $this->container->get(PageServiceHandler::class);
	}

	public function init() {

		$this->bootFrameworkProviders();

		add_action($this->tDom . '/on/framework/initiated', [$this, 'systemActions']);
	}

	private function bootFrameworkProviders() {
		$conf = require_once __DIR__ . '/serviceConf.php';

		if(!empty($conf['services'])) {
			foreach($conf['services'] as $name => $handler) {
				$this->getContainer()->set($name, $handler);
			}
		}

		$hooks = apply_filters('', [
			'pages',
			'enqueue',
			'filters',
			'actions',
		],                     $this);

		foreach($hooks as $hook) {
			$this->includeHookFl($hook);
		}
	}

	private function includeHookFl($fl) {

		$app = $this;

		switch($fl) {
			case 'pages':
				$page = $this->get('adminPageService');
				break;
			case 'enqueue':
				$enqueue = $this->get('enqueueService');
				break;
			case 'filters':
				$filters = $this->get('enqueueService');;
			case 'actions':
				$actions = $this->get('enqueueService');
		}

		$pageFl = $this->pluginHooksDir . $fl . '.php';

		if(file_exists($pageFl)) {
			require_once $pageFl;
		}
	}


	/**
	 * @return void
	 * @throws \Atiqsu\WpPave\Container\ContainerExceptionInterface
	 * @throws \Atiqsu\WpPave\Container\NotFoundExceptionInterface
	 */
	public function systemActions() {

		$page = $this->get('adminPageService');
		$enqueue = $this->get('enqueueService');

		add_action('admin_menu', [$page, 'init']);

		$enqueue->init($this);
	}
}
