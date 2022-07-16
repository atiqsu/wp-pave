<?php

namespace Atiqsu\WpPave\System;

use Atiqsu\WpPave\Config\Config;
use Atiqsu\WpPave\Container\Container;
use Atiqsu\WpPave\Handlers\PageServiceHandler;
use Atiqsu\WpPave\Handlers\RouterHandler;
use Atiqsu\WpPave\Http\Api;
use Atiqsu\WpPave\Policy\PublicPolicy;
use Atiqsu\WpPave\Providers\AdminNoticeService;

/**
 * What the f** this is ? - Well right now it's not DI container ......
 *
 */
class Application {

	private static ?Application $instance = null;

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
	protected string $pluginRoutesDir;


	/*
	 * Just to prevent instantiating it
	 *
	 */
	private function __construct($path) {

		$this->container = new Container();

		$this->path = $path;

		$this->pluginBaseUrl   = trailingslashit(plugin_dir_url($path));
		$this->pluginBaseDir   = trailingslashit(plugin_dir_path($path));
		$this->pluginAppDir    = $this->pluginBaseDir . 'app/';
		$this->pluginHooksDir  = $this->pluginBaseDir . 'app/Hooks/';
		$this->pluginRoutesDir = $this->pluginBaseDir . 'app/Routes/';
		$this->pluginAssetDir  = $this->pluginBaseDir . 'app/assets/';
		$this->pluginAssetUrl  = $this->pluginBaseUrl . 'app/assets/';


		//$this->pluginFile     = $path;
		//$this->basePath       = untrailingslashit(plugin_dir_path($path));
		//$this->pluginBasename = plugin_basename($path);

		$this->bootFrameworkMuProviders();
		$this->loadPluginConfig();
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

	private function loadPluginConfig($ext = '.php') {

		$confFl = $this->pluginAppDir . '/config' . $ext;

		if(file_exists($confFl)) {
			$conf = require_once $confFl;
			if(!empty($conf)) {
				$config = $this->container->resolve(Config::class, 'configService');
				foreach($conf as $key => $val) {
					$config->setVal($key, $val);
				}
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

		$this->getContainer()->register(Config::class);

		$this->bootFrameworkProviders();

		add_action($this->tDom . '/on/framework/initiated', [$this, 'systemActions']);
	}

	private function bootFrameworkProviders() {
		$conf = require_once __DIR__ . '/serviceConf.php';

		if(!empty($conf['services'])) {
			foreach($conf['services'] as $name => $handler) {
				$this->getContainer()->register($name, $handler);
			}
		}

		$hooks = apply_filters(
			'wp-pave/initialService',
			[
				'pages',
				'enqueue',
				'filters',
				'actions',
				'routes.api',
			],
			$this
		);

		foreach($hooks as $hook) {
			$this->includeHookFl($hook);
		}

		//Load project specific settings

		/**
		 * todo - we need more work on config
		 */
		$envFl = $this->pluginAppDir . 'config.php';

		if(file_exists($envFl)) {
			$env = require $envFl;
			if(!empty($env)) {
				$conf = $this->get(Config::class);
				foreach($env as $ky => $vl) {
					$conf->setVal($ky, $vl);
				}
			}
		}
	}

	private function includeHookFl($fl) {

		$app       = $this;
		$parentDir = $this->pluginHooksDir;
		$ext       = '.php';

		switch($fl) {
			case 'pages':
				$page = $this->get('adminPageService');
				break;
			case 'enqueue':
				$enqueue = $this->get('enqueueService');
				break;
			case 'filters':
				$filters = $this->get('filterService');
				break;
			case 'actions':
				$actions = $this->get('actionService');
				break;
			case 'routes.api':
				$router    = $this->get('routerService');
				$parentDir = $this->pluginRoutesDir;
				$fl        = 'api';
				break;
		}

		$pageFl = $parentDir . $fl . $ext;

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

		$page    = $this->get('adminPageService');
		$enqueue = $this->get('enqueueService');

		//$action = $this->get('actionService');
		//$filter = $this->get('filterService');

		add_action('admin_menu', [$page, 'init']);

		$enqueue->init($this);

		//$router = new RouterHandler();
		//$router = $this->get('routerService');


		// policy handler as permission callback in register routes
		//


		/*
				Api::group(['middleware' => 'test'], function () {
					Api::get('test/{id}', ApiController::class);
				});
		*/
		/**
		 *
		 *
		 * $router->prefix('public')->withPolicy('PublicPolicy')->group(function ($router) {
		 *
		 * $router->any('bounce_handler/{service_name}/handle/{security_code}', 'WebhookBounceController@handleBounce')
		 * ->alphaNumDash('service_name')
		 * ->alphaNumDash('security_code');
		 *
		 * $router->any('bounce_handler/{service_name}/{security_code}', 'WebhookBounceController@handleBounce')
		 * ->alphaNumDash('service_name')
		 * ->alphaNumDash('security_code');
		 *
		 * });
		 *
		 *
		 * //*/

	}
}
