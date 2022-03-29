<?php

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Contracts\PageInterface;
use Atiqsu\WpPave\Exceptions\PageRouteException;
use Atiqsu\WpPave\Pages\AdminPage;
use Atiqsu\WpPave\Pages\AdminSubPage;
use Atiqsu\WpPave\System\Application;

class PageServiceHandler implements PageInterface {

	private array $pageList;
	private array $subPgList;
	private array $registry;
	private string $parent;
	private static int $pageCount = 0;

	public function __construct() {
		$this->pageList = [];
		$this->registry = [];
	}

	/**
	 * @param string $parentSlug
	 * @return $this
	 * @throws PageRouteException
	 */
	public function parent(string $parentSlug): PageServiceHandler {

		if(!$this->has($parentSlug)) {
			throw new PageRouteException('Parent route "' . $parentSlug . '" not found, please register parent route first');
		}

		$this->parent = $parentSlug;

		$this->registry['child'][$parentSlug] = [];

		return $this;
	}

	public function sub($slug): AdminSubPage {

		if(is_null($this->parent)) {
			throw new PageRouteException('Undefined parent. You must call "parent" method first.');
		}

		if(isset($this->registry['child'][$this->parent][$slug])) {
			return $this->registry['child'][$this->parent][$slug];
		}

		$sub = new AdminSubPage($this->parent, $slug);

		$this->registry['child'][$this->parent][$slug] = $sub;

		$sub->pageTitle('Sub page - ' . self::$pageCount . ' booted');
		$sub->menuTitle('Sub page - ' . self::$pageCount);

		$this->registry['parent'][$slug] = 'admin|child';
		$this->subPgList[$slug] = $sub;

		return $sub;
	}

	public function new($slug): AdminPage {

		if(isset($this->registry['parent'][$slug])) {
			return $this->registry['parent'][$slug];
		}

		self::$pageCount++;

		$this->registry['parent'][$slug] = 'admin|parent';
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

			if($this->has($pg)) {
				foreach($this->subPgList as $sId => $subObj) {
					$subObj->boot($app);
				}
			}
		}
	}

	/**
	 * @param $slug
	 * @return bool
	 */
	private function has($slug): bool {

		return isset($this->registry['parent'][$slug]);
	}
}
