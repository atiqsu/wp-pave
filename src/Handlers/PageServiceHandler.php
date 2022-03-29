<?php

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Contracts\PageInterface;
use Atiqsu\WpPave\Pages\AdminPage;
use Atiqsu\WpPave\System\Application;

class PageServiceHandler implements PageInterface {

	private array $pageList;
	private array $registry;
	private static int $pageCount = 0;

	public function __construct() {
		$this->pageList = [];
		$this->registry = [];
	}

	public function parent($parentSlug) {

	}

	public function sub() {

	}

	public function new($slug): AdminPage {

		if(isset($this->registry[$slug])) {
			return $this->registry[$slug];
		}

		self::$pageCount++;

		$this->registry[$slug] = 'admin|parent';
		$this->pageList[$slug] = new AdminPage($slug);

		$this->pageList[$slug]->pageTitle('Parent page - ' . self::$pageCount . ' booted');
		$this->pageList[$slug]->menuTitle('Parent page - ' . self::$pageCount);

		return $this->pageList[$slug];
	}

	public function handle($network_wide = false) {
		/**
		 * We handle nothing on boot of the service
		 * We separately call the init of the service
		 */
	}

	public function init() {
		$app = Application::getInstance();
		foreach($this->pageList as $pg => $obj) {
			$obj->boot($app);
		}
	}
}
