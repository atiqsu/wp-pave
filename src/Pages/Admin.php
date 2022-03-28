<?php

namespace Atiqsu\WpPave\Pages;

use Atiqsu\WpPave\Contracts\PageInterface;
use Atiqsu\WpPave\System\Application;

class Admin {

	private string $slug;
	private string $pTtl;
	private string $mTtl;
	private string $cap;
	private string $icon;
	private string $pos;

	private string $controller;
	private string $method = 'index';

	public function __construct($slug, $cap, $controller, $method, $mTtl, $pTtl, $icon, $pos) {
		$this->cap = $cap;
		$this->slug = $slug;
		$this->controller = $controller;
		$this->method = $method;

		$this->pTtl = $pTtl;
		$this->mTtl = $mTtl;
		$this->pos = $pos;
		$this->icon = $icon;
	}

	public function boot(Application $app) {
		$con = $app->get($this->controller);

		if($con instanceof PageInterface) {

			$pos = $this->pos < 0 ? null : $this->pos;

			add_menu_page($this->pTtl, $this->mTtl, $this->cap, $this->slug, [$con, $this->method], $this->icon, $pos);
		}
	}
}

