<?php

namespace Atiqsu\WpPave\Util;

final class HtmlNoticePrinter {

	private array $printing;

	public function __construct(array $notice = []) {
		$this->printing = $notice;
	}

	public function print() {

		$cls = $this->printing['d'] ? 'is-dismissible ' : '';
		$cls .= implode(' ', $this->printing['c']);
		$msg = $this->printing['m'];

		printf(
			'<div id="%s" class="%s"><p>%s</p></div>',
			esc_attr($this->printing['_id']),
			esc_attr($cls),
			esc_html($msg)
		);
	}

}
