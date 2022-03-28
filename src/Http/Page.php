<?php

namespace Atiqsu\WpPave\Http;

use Atiqsu\WpPave\Contracts\PageInterface;
use Atiqsu\WpPave\Pages\Admin;
use Atiqsu\WpPave\System\Application;

class Page {

	private array $pageList;
	private ?string $slug;
	private string $pTtl;
	private string $mTtl;
	private string $cap = '';
	private string $icon = '';
	private ?string $controller;
	private string $method = 'index';
	private int $pos = -9;

	private static int $pageCount = 0;

	protected array $registry = [];

	/**
	 * @param $slug
	 * @return $this
	 */
	public function new($slug): Page {

		if(isset($this->registry[$slug])) {
			return $this;
		}

		$this->registry[$slug] = 'admin|parent';
		$this->slug = $slug;
		self::$pageCount++;

		$this->pTtl = 'Parent page - ' . self::$pageCount . ' booted';
		$this->mTtl = 'Parent page - ' . self::$pageCount;

		return $this;
	}

	public function caller(string $controller, string $method = 'index'): Page {

		$this->method     = $method;
		$this->controller = $controller;

		return $this;
	}

	public function menuTitle(string $ttl): Page {
		$this->mTtl = $ttl;

		return $this;
	}

	public function pageTitle(string $ttl): Page {
		$this->pTtl = $ttl;

		return $this;
	}

	public function setCapability($cap): Page {
		$this->cap = $cap;

		return $this;
	}

	public function setIconUrl(string $icon = null): Page {
		$this->icon = $icon;

		return $this;
	}

	public function setPosition(int $pos): Page {
		$this->pos = $pos;

		return $this;
	}

	public function register() {

		$this->pageList[$this->slug] = new Admin(
			$this->slug,
			$this->cap,
			$this->controller,
			$this->method,
			$this->mTtl,
			$this->pTtl,
			$this->icon,
			$this->pos
		);

		$this->slug       = null;
		$this->controller = null;
		$this->method     = 'index';
	}

	public function init() {
		$app = Application::getInstance();
		foreach($this->pageList as $pg => $obj) {
			$obj->boot($app);
		}
	}
}
