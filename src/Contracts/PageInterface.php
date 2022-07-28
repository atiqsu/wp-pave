<?php

namespace Atiqsu\WpPave\Contracts;

interface PageInterface {
	public function __construct();
	public function setPageSlug(string $val);
}
