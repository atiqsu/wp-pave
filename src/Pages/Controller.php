<?php

namespace Atiqsu\WpPave\Pages;

use Atiqsu\WpPave\Contracts\PageInterface;

class Controller implements PageInterface {

	protected string $parentSlug;
	public string $pageSlug;

	final public function __construct() {

	}

	public function setParentPageSlug(string $val) {
		$this->parentSlug = $val;

		return $this;
	}

	public function setPageSlug(string $val) {
		$this->pageSlug = $val;

		return $this;
	}
}
