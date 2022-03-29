<?php

namespace Atiqsu\WpPave\Pages;

use Atiqsu\WpPave\System\Application;

class AdminPage {

	protected string $slug;
	protected string $pTtl;
	protected string $mTtl;
	protected string $cap = 'manage_options';
	protected string $icon = '';
	protected int $pos = -9;

	protected string $controller;
	protected string $method = 'index';

	public function __construct($slug, $cap = '') {
		$this->cap        = empty($cap) ? $this->cap : $cap;
		$this->slug       = $slug;
		$this->controller = '';
	}

	public function register(): bool {

		return true;
	}

	public function boot(Application $app) {

		$pos = $this->pos < 0 ? null : $this->pos;

		if(empty($this->controller)) {
			add_menu_page(
				$this->pTtl,
				$this->mTtl,
				$this->cap,
				$this->slug,
				'',
				$this->icon,
				$pos
			);

			return;
		}

		if($this->controller instanceof \Closure) {

			add_menu_page(
				$this->pTtl,
				$this->mTtl,
				$this->cap,
				$this->slug,
				$this->controller,
				$this->icon,
				$pos
			);

			return;
		}

		$con = $this->resolve($app, $this->controller);

		if($con instanceof Controller) {

			add_menu_page(
				$this->pTtl,
				$this->mTtl,
				$this->cap,
				$this->slug,
				[$con, $this->method],
				$this->icon,
				$pos
			);
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

	/**
	 * todo - learning tips, default values of menu position
	 * 2 – Dashboard
	 * 4 – Separator
	 * 5 – Posts
	 * 10 – Media
	 * 15 – Links
	 * 20 – Pages
	 * 25 – Comments
	 * 59 – Separator
	 * 60 – Appearance
	 * 65 – Plugins
	 * 70 – Users
	 * 75 – Tools
	 * 80 – Settings
	 * 99 – Separator
	 *
	 * For the Network Admin menu, the values are different:
	 * 2 – Dashboard
	 * 4 – Separator
	 * 5 – Sites
	 * 10 – Users
	 * 15 – Themes
	 * 20 – Plugins
	 * 25 – Settings
	 * 30 – Updates
	 * 99 – Separator
	 *
	 * @param string $pos
	 * @return $this
	 */
	public function setPos(string $pos): AdminPage {
		$this->pos = (int)$pos;

		return $this;
	}

	protected function resolve(Application $app, $name) {

		if(!$app->has($name)) {
			$app->getContainer()->register($name);
		}

		return $app->get($name);
	}
}

