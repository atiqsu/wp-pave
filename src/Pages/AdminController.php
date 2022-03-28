<?php

namespace Atiqsu\WpPave\Pages;

class AdminController implements \Atiqsu\WpPave\Contracts\PageInterface {

	public function index() {
		echo '<pre>';
		var_dump('From admin controller .... with page interface.');
		echo '</pre>';
	}
}
