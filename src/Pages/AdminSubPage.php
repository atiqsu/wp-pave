<?php

namespace Atiqsu\WpPave\Pages;

use Atiqsu\WpPave\Contracts\PageInterface;
use Atiqsu\WpPave\System\Application;

class AdminSubPage extends AdminPage {

	private string $parentSlug;

	public function __construct($parentSlug, $slug, $cap = '') {
		parent::__construct($slug, $cap);

		/**
		 * todo - learning tips, parent slug
		 * Slugs for $parent_slug (first parameter)
		 * - Dashboard: ‘index.php’
		 * - Posts: ‘edit.php’
		 * - Media: ‘upload.php’
		 * - Pages: ‘edit.php?post_type=page’
		 * -  Comments: ‘edit-comments.php’
		 * - Custom Post Types: ‘edit.php?post_type=your_post_type’
		 * - Appearance: ‘themes.php’
		 * - Plugins: ‘plugins.php’
		 * - Users: ‘users.php’
		 * - Tools: ‘tools.php’
		 * - Settings: ‘options-general.php’
		 * - Network Settings: ‘settings.php’
		 *
		 */
		$this->parentSlug = $parentSlug;
	}


	public function boot(Application $app) {

		$con = $this->resolve($app);
		$pos = $this->pos < 0 ? null : $this->pos;

		if($con instanceof PageInterface) {
			add_submenu_page(
				$this->parentSlug,
				$this->pTtl,
				$this->mTtl,
				$this->cap,
				$this->slug,
				[$con, $this->method],
				$pos
			);
		} else {
			add_submenu_page(
				$this->parentSlug,
				$this->pTtl,
				$this->mTtl,
				$this->cap,
				$this->slug,
				'',
				$pos
			);
		}
	}
}
