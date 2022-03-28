<?php

namespace Atiqsu\WpPave\Pages;

final class AdminController extends Controller {

	public function index() {
		echo '<pre>';
		var_dump('From admin controller .... with page interface.');
		echo '</pre>';
	}
}
