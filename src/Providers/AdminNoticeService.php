<?php

namespace Atiqsu\WpPave\Providers;

class AdminNoticeService implements NotifyInterface {

	protected string $scriptVersion = '1.0.0';
	protected string $notice;
	protected array $notices = [];
	private string $printing;
	private bool $isDismissible = true;
	private static int $count = 0;

	private function getUniqueId(): string {
		return 'wpPave_' . time() . '_' . self::$count;
	}

	private function setUniqueId($val): AdminNoticeService {
		self::$count++;
		$this->notice = $uniqueId ?? $this->getUniqueId();

		return $this;
	}

	public function new($uniqueId = null): AdminNoticeService {

		$this->setUniqueId($uniqueId);

		$this->notices[$this->notice] = [
			'm' => 'wp pave default message....no message set by developer',
			'c' => ['wp-pave-notice notice'],
			'd' => $this->isDismissible,
		];

		return $this;
	}

	public function errorNotice($msg, $noticeId = null): AdminNoticeService {

		return $this->new($noticeId)
		            ->setNoticeType('error')
		            ->message($msg);
	}

	public function infoNotice($msg, $noticeId = null): AdminNoticeService {

		return $this->new($noticeId)
		            ->setNoticeType('info')
		            ->message($msg);
	}

	public function successNotice($msg, $noticeId = null): AdminNoticeService {

		return $this->new($noticeId)
		            ->setNoticeType('success')
		            ->message($msg);
	}

	public function warningNotice($msg, $noticeId = null): AdminNoticeService {

		return $this->new($noticeId)
		            ->setNoticeType('warning')
		            ->message($msg);
	}

	public function defaultNotice($msg, $noticeId = null): AdminNoticeService {

		return $this->new($noticeId)
		            ->setNoticeType('default')
		            ->message($msg);
	}

	/**
	 * notice-error
	 * notice-warning
	 * notice-info
	 * notice-success
	 *
	 * @see - https://developer.wordpress.org/reference/hooks/admin_notices/
	 * @param $type
	 * @return $this
	 */
	public function setNoticeType(string $type): AdminNoticeService {

		$this->notices[$this->notice]['c'][] = 'notice-' . $type;

		return $this;
	}

	public function message($msg): AdminNoticeService {

		$this->notices[$this->notice]['m'] = $msg;

		return $this;
	}

	public function dismissible(bool $make = true): AdminNoticeService {

		$this->isDismissible = $make;

		return $this;
	}

	public function notify() {

		//$screen = get_current_screen();

		foreach($this->notices as $id => $notice) {
			$this->printing = $id;
			add_action('admin_notices', [$this, 'printNotice']);
		}
	}

	public function printNotice() {
		$cls = $this->notices[$this->printing]['d'] ? 'is-dismissible ' : '';
		$cls .= implode(' ', $this->notices[$this->printing]['c']);
		$msg = $this->notices[$this->printing]['m'];

		printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($cls), esc_html($msg));
	}
}
