<?php
/**
 *
 * @package User Details Extension
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\userdetails\acp;

class userdetails_info
{
	public function module()
	{
		return [
			'filename'	=> '\david63\userdetails\acp\userdetails_module',
			'title' 	=> 'ACP_USER_DETAILS',
			'modes' 	=> [
				'main'	=> ['title' => 'ACP_USER_DETAILS', 'auth' => 'ext_david63/userdetails && acl_a_user', 'cat' => ['ACP_CAT_USERS']],
			],
		];
	}
}
