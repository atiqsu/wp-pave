<?php

namespace Atiqsu\WpPave\Pages;

use Atiqsu\WpPave\Contracts\PageInterface;
use Atiqsu\WpPave\System\Application;

class AdminPage {

	protected string $slug;
	protected string $pTtl;
	protected string $mTtl;
	protected string $cap = 'manage_options';
	protected string $icon;
	protected int $pos;

	protected string $controller;
	protected string $method = 'index';

	public function __construct($slug, $cap = '', $controller = '', $method = '', $mTtl = '', $pTtl = '', $icon = '', $pos = -9) {
		$this->cap        = empty($cap) ? $this->cap : $cap;
		$this->slug       = $slug;
		$this->controller = $controller;
		$this->method     = $method;

		$this->pTtl = $pTtl;
		$this->mTtl = $mTtl;
		$this->pos  = $pos;
		$this->icon = $icon;
	}

	public function register(): bool {

		return true;
	}

	public function boot(Application $app) {

		if(!$app->has($this->controller)) {
			$app->getContainer()->register($this->controller);
		}

		$con = $app->get($this->controller);

		if($con instanceof PageInterface) {

			$pos = $this->pos < 0 ? null : $this->pos;

			add_menu_page($this->pTtl, $this->mTtl, $this->cap, $this->slug, [$con, $this->method], $this->icon, $pos);
		}
	}

	public function caller(string $controller, string $method = 'index'): AdminPage {
		$this->method     = $method;
		$this->controller = $controller;

		return $this;
	}

	public function pageTitle(string $pTtl): AdminPage {
		$this->pTtl = $pTtl;

		return $this;
	}

	public function menuTitle(string $mTtl): AdminPage {
		$this->mTtl = $mTtl;

		return $this;
	}

	public function setCap($cap): AdminPage {
		$this->cap = $cap;

		return $this;
	}

	public function setIcon(string $icon): AdminPage {
		$this->icon = $icon;

		return $this;
	}

	public function setPos(string $pos): AdminPage {
		$this->pos = (int)$pos;

		return $this;
	}
}

