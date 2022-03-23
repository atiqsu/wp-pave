<?php

namespace Atiqsu\WpPave\Providers;

class AdminNoticeService implements NotifyInterface {

	protected string $scriptVersion = '1.0.0';
	protected string $notice;
	protected array $notices = [];
	private string $printing;
	private bool $isDismissible = true;

	public function new($textDomain, $uniqueId = null): AdminNoticeService {

		$textDomain = empty($textDomain) ? 'wp-pave-default' : $textDomain;
		$uniqueId   = $uniqueId ?? 'wpPave_' . time();

		$this->notice             = $uniqueId;
		$this->notices[$uniqueId] = [
			't' => $textDomain,
			'm' => 'wp pave default message....no message set by developer',
			'c' => ['wp-pave-notice notice'],
			'd' => $this->isDismissible,
		];

		return $this;
	}

	public function errorNotice(): AdminNoticeService {

		$this->notices[$this->notice]['c'][] = 'notice-error';

		return $this;
	}

	public function infoNotice(): AdminNoticeService {

		$this->notices[$this->notice]['c'][] = 'notice-info';

		return $this;
	}

	public function successNotice(): AdminNoticeService {

		$this->notices[$this->notice]['c'][] = 'notice-success';

		return $this;
	}

	public function defaultNotice(): AdminNoticeService {

		$this->notices[$this->notice]['c'][] = 'notice-default';

		return $this;
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
	public function NoticeType(string $type = ''): AdminNoticeService {

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
		//

		foreach($this->notices as $id => $notice) {

			$this->printing = $id;

			add_action('admin_notices', [$this, 'printNotice']);
		}

		add_action('admin_notices', [$this, 'get_notice']);

		add_action('admin_notices', [$this, 'get_notice']);

		add_action('admin_notices', function () {
			echo '<div class="error"><p>FluentCRM Pro requires to update to the latest version. <a href="' . admin_url('plugins.php?s=fluentcampaign-pro&plugin_status=all') . '">Please update FluentCRM Pro</a>. Otherwise, it will not work properly.</p></div>';
		});
	}

	public function printNotice() {
		$cls = $this->notices[$this->printing]['d'] ? 'is-dismissible ' : '';
		$cls .= implode(' ', $this->notices[$this->printing]['c']);
		$msg = $this->notices[$this->printing]['m'];

		printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($cls), esc_html($msg));
	}
}
