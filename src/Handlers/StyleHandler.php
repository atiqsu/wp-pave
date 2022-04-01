<?php
/**
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 30/3/22 - 12:02 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Contracts\EnqueueInterface;

/**
 * wp_register_style( string $handle, string|bool $src, string[] $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_enqueue_block_style( string $block_name, array $args )
 * wp_enqueue_media( array $args = array() )
 * wp_enqueue_editor()
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 31/3/22 - 11:30 AM
 *
 * Package - Atiqsu\WpPave\Handlers
 * StyleHandler is responsible for
 *
 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
 */
class StyleHandler implements EnqueueInterface {

	/**
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @var string
	 */
	private string $handle;

	/**
	 * getHandle is responsible for doing some .
	 *
	 * @return string
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 31/3/22 - 11:42 AM
	 *
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 */
	public function getHandle(): string {
		return $this->handle;
	}

	public function setHandle(string $handle): StyleHandler {
		$this->handle = $handle;

		return $this;
	}

}
