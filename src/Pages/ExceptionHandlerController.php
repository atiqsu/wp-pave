<?php

namespace Atiqsu\WpPave\Pages;

class ExceptionHandlerController extends AdminController {

	public function index() {

		echo 'Page can not be created due to callable controller exception.';
	}
}
