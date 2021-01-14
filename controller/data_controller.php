<?php
/**
*
* @package User Details Extension
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\userdetails\controller;

use phpbb\config\config;
use phpbb\config\db_text;
use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\pagination;
use phpbb\user;
use phpbb\group\helper;
use phpbb\language\language;
use phpbb\di\service_collection;
use david63\userdetails\core\functions;

/**
* Data controller
*/
class data_controller
{
	/** @var config */
	protected $config;

	/** @var db_text */
	protected $config_text;

	/** @var driver_interface */
	protected $db;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var pagination */
	protected $pagination;

	/** @var user */
	protected $user;

	/** @var helper */
	protected $group_helper;

	/** @var language */
	protected $language;

	/** @var service_collection */
	protected $type_collection;

	/** @var functions */
	protected $functions;

	/** @var string custom select_ary */
	protected $select_ary;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpBB extension */
	protected $php_ext;

	/** @var string Custom form action */
	protected $u_action;

	/** @var array phpBB tables */
	protected $tables;

	/** @var string custom constants */
	protected $constants;

	/** @var string */
	protected $ext_images_path;

	/**
	 * Constructor for data controller
	 *
	 * @param config              	$config             Config object
	 * @param db_text             	$config_text        Config text object
	 * @param driver_interface 		$db                 Db object
	 * @param request            	$request            Request object
	 * @param template          	$template           Template object
	 * @param pagination			$pagination         Pagination object
	 * @param user					$user               User object
	 * @param helper               	$group_helper       Group helper object
	 * @param language          	$language           Language object
	 * @param service_collection	$type_collection	CPF data
	 * @param functions				functions			Functions for the extension
	 * @param array					$select_ary			Custom select data
	 * @param string				$root_path    		phpBB root path
	 * @param string				$php_ext            phpBB extension
	 * @param array					$tables				phpBB db tables
	 * @param array					$constants			phpBB constants
	 * @param string				$ext_images_path    Path to this extension's images
	 *
	 * @return \david63\userdetails\controller\data_controller
	 * @access public
	 */
	public function __construct(config $config, db_text $config_text, driver_interface $db, request $request, template $template, pagination $pagination, user $user, helper $group_helper, language $language, service_collection $type_collection, functions $functions, array $select_ary, string $root_path, string $php_ext, array $tables, array $constants, string $ext_images_path)
	{
		$this->config			= $config;
		$this->config_text 		= $config_text;
		$this->db  				= $db;
		$this->request			= $request;
		$this->template			= $template;
		$this->pagination		= $pagination;
		$this->user				= $user;
		$this->group_helper		= $group_helper;
		$this->language			= $language;
		$this->type_collection 	= $type_collection;
		$this->functions		= $functions;
		$this->select_ary		= $select_ary;
		$this->root_path		= $root_path;
		$this->php_ext			= $php_ext;
		$this->tables			= $tables;
		$this->constants		= $constants;
		$this->ext_images_path	= $ext_images_path;
	}

	/**
	* Display the output selections for this extension
	*
	* @return null
	* @access public
	*/
	public function select_output()
	{
		// Load the language files
		$this->language->add_lang(array('acp_userdetails', 'userdetails_explain', 'acp_common'), $this->functions->get_ext_namespace());

		// Create a form key for preventing CSRF attacks
		add_form_key($this->constants['form_key']);

		$back = false;

		// Unset the save flag
		$this->config->set('user_details_save_flag', false, false);

		// Retrieve the saved options
		$save_opt	= $this->config_text->get_array(array('user_details_opts'));
		$save_opts 	= (array) json_decode($save_opt['user_details_opts']);

		$this->select_ary = array_merge($this->select_ary, $this->get_cpf_data());

		foreach ($this->select_ary as $key => $row)
		{
			$attrib_explain = $this->language->lang($row['attribute'] . '_EXPLAIN');

			if ($row['cpf'])
			{
				$attrib_explain = ($row['explain']) ? $row['explain'] : $this->language->lang($row['attribute']);
			}

			$this->template->assign_block_vars('select_row', array(
				'ATTRIBUTE'			=> $this->language->lang($row['attribute']),
				'ATTRIBUTE_EXPLAIN'	=> $attrib_explain,
				'ID'				=> $row['id'],
				'OPT_SET'			=> in_array('s' . $key, $save_opts),
			));
		}

		// Template vars for header panel
		$version_data	= $this->functions->version_check();

		// Are the PHP and phpBB versions valid for this extension?
		$valid = $this->functions->ext_requirements();

		$this->template->assign_vars(array(
			'DOWNLOAD'			=> (array_key_exists('download', $version_data)) ? '<a class="download" href =' . $version_data['download'] . '>' . $this->language->lang('NEW_VERSION_LINK') . '</a>' : '',

			'EXT_IMAGE_PATH'	=> $this->ext_images_path,

			'HEAD_TITLE'		=> $this->language->lang('ACP_USER_DETAILS'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('ACP_USER_DETAILS_CONFIG'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'PHP_VALID' 		=> $valid[0],
			'PHPBB_VALID' 		=> $valid[1],

			'S_BACK'			=> $back,
			'S_VERSION_CHECK'	=> (array_key_exists('current', $version_data)) ? $version_data['current'] : false,

			'VERSION_NUMBER'	=> $this->functions->get_meta('version'),
		));
	}

	/**
	 * Display the output from this extension
	 *
	 * @param $mode
	 * @return null
	 * @access public
	 */
	public function display_output($mode)
	{
		// Load the language files
		$this->language->add_lang(array('acp_userdetails', 'acp_common'), $this->functions->get_ext_namespace());

		// Start initial var setup
		$start			= $this->request->variable('start', '');
		$fc				= $this->request->variable('fc', '');
		$fb				= $this->request->variable('fb', '');
		$sort_key		= $this->request->variable('sk', 'u');
		$sd = $sort_dir	= $this->request->variable('sd', 'a');
		$disp_ary		= $this->request->variable('disp_ary', '');
		$display_ary	= $this->request->variable('mark', array(''));

		$display_ary	= ($display_ary) ? $display_ary : json_decode(str_replace("'", '"', $disp_ary));
		$error = $back 	= false;

		// Is the submitted form is valid - we do not want to check after the first time it is displayed
		if ($mode == 'display' && !check_form_key($this->constants['form_key']) && $start === 0)
		{
			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}

		if (empty($display_ary))
		{
			trigger_error($this->language->lang('NO_ATTRIBUTES_SELECTED') . adm_back_link($this->u_action));
		}

		// Reset $start to zero if it is empty
		$start = ($start == '') ? 0 : $start;

		if ($mode == 'clear_filters')
		{
			$fc = $fb		= '';
			$sd = $sort_dir	= 'a';
			$sort_key		= 'u';
		}

		// Create some arrays of data that we will need
		$sort_ary	= array('u' => $this->language->lang('SORT_USERNAME'));
		$order_ary	= array('u' => 'u.username_clean');
		$filter_ary	= array('u' => $this->language->lang('SORT_USERNAME'));
		$save_ary	= [];

		// Create the CSV file
		if ($mode == 'csv')
		{
			// Make sure that the run time can cope with large boards
			@set_time_limit(240);

			$filename	= 'phpBB_users_' . date('Ymd') . '.csv';
			$fp 		= fopen('php://output', 'w');
			$csv_data	= '"' . $this->language->lang('USERNAME') . '"' . $this->constants['csv_delimiter'];
		}

		$headings = '';

		$this->select_ary = array_merge($this->select_ary, $this->get_cpf_data());

		// Create the headings row
		foreach ($display_ary as $rows)
		{
			foreach ($this->select_ary as $key => $data)
			{
				if ($data['id'] == $rows)
				{
					if ($this->select_ary[$key]['id'] !== end($display_ary))
					{
						$headings .= '<div class="table-header-cell">' . $this->language->lang($data['attribute']) . '</div>';
					}
					else
					{
						$headings .= '<div class="table-header-cell-right">' . $this->language->lang($data['attribute']) . '</div>';
					}

					if ($mode == 'csv')
					{
						$csv_data	.= '"' . $this->language->lang($data['attribute']) . '"' . $this->constants['csv_delimiter'];
					}

					$save_ary[]				= 's' . $key;
					$sort_ary['s' . $key]	= $this->language->lang($data['attribute']);
					$order_ary['s' . $key] 	= (substr($data['id'], 0, 2) == 'pf') ? 'pf.' . $data['id'] : 'u.' . $data['id'];

					if ($data['filter'])
					{
						$filter_ary['s' . $key] = $this->language->lang($data['attribute']);
					}
				}
			}
		}

		if ($mode == 'csv')
		{
			$csv_data .= "\n";
		}

		// Save the selected attributes - we only need to save them once
		if (!$this->config['user_details_save_flag'])
		{
			$this->config_text->set_array(array('user_details_opts' => json_encode($save_ary)));
			$this->config->set('user_details_save_flag', true, false);
		}

		// Sorting & filtering
		// First make sure sort & filter keys are still valid
		$sort_key 	= (!in_array($sort_key, $save_ary)) ? 'u' : $sort_key;
		$fc 		= (!array_key_exists($fb, $order_ary)) ? '' : $fc;

		$sort_dir	= ($sort_dir == 'd') ? ' DESC' : ' ASC';
		$order_by	= $order_ary[$sort_key] . $sort_dir . ', u.username_clean ASC';
		$filter_by	= '';

		if ($fc == 'other')
		{
			for ($i = ord($this->language->lang('START_CHARACTER')); $i	<= ord($this->language->lang('END_CHARACTER')); $i++)
			{
				$filter_by .= ' AND ' . $order_ary[$fb] . ' NOT ' . $this->db->sql_not_like_expression(utf8_clean_string(chr($i)) . $this->db->get_any_char());
			}
		}
		else if ($fc)
		{
			$filter_by .= ' AND ' . $order_ary[$fb] . ' ' . $this->db->sql_like_expression(utf8_clean_string(substr($fc, 0, 1)) . $this->db->get_any_char());
		}

		$limit_days = [];
		$s_sort_key = $s_limit_days = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_ary, $sort_days, $sort_key, $sd, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Get default style name (we may need this later)
		$sql = 'SELECT style_name
			FROM ' . $this->tables['styles'] . '
			WHERE style_id = ' . (int) $this->config['default_style'];

		$result 		= $this->db->sql_query($sql);
		$default_style	= $this->db->sql_fetchfield('style_name');

		$this->db->sql_freeresult($result);

		// Create the output
		$sql = $this->db->sql_build_query('SELECT', array(
			'SELECT'	=> 'g.group_name, g.group_type, s.style_name, u.*',
			'FROM'		=> array(
				$this->tables['users'] => 'u',
			),
			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array($this->tables['groups'] => ' g',),
					'ON'	=> 'u.group_id = g.group_id',
				),
				array(
					'FROM'	=> array($this->tables['styles'] => ' s',),
					'ON'	=> 'u.user_style = s.style_id',
				),
				array(
					'FROM'	=> array($this->tables['profile_fields_data'] => ' pf'),
					'ON'	=> 'u.user_id = pf.user_id',
				),
			),
			'WHERE' => 'u.user_type <> ' . (int) $this->constants['user_ignore'] .
				$filter_by,
			'ORDER_BY' => $order_by,
		));

		if ($mode != 'csv')
		{
			$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);
		}
		else
		{
			$result = $this->db->sql_query($sql);
		}

		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_data[] = $row;
		}

		$this->db->sql_freeresult($result);

		// Check that we have some data to output
		if (empty($user_data))
		{
			trigger_error($this->language->lang('NO_DATA') . adm_back_link($this->u_action));
		}
		else // Carry on with the output
		{
			if (!function_exists('phpbb_get_user_rank'))
			{
				include("$this->root_path/includes/functions_display.$this->php_ext");
			}

			foreach ($user_data as $row)
			{
				$user_rank_data = phpbb_get_user_rank($row, $row['user_posts']);

				if ($row['group_name'] != '')
				{
					$group_id = $this->group_helper->get_name($row['group_name']);
				}
				else
				{
					$group_id 	= $this->language->lang('NO_GROUP');
					$error		= true;
				}

				if ($row['style_name'] != '')
				{
					$style_name = $row['style_name'];
				}
				else
				{
					$style_name	= $this->language->lang('DEFAULT_STYLE', $default_style);
					$error		= true;
				}

				// Create an array of all the data so that we can format the items for output
				$user_vars = array(
					'group_id'				=> $group_id,
					'user_allow_massemail'	=> ($row['user_allow_massemail'] == true) ? $this->language->lang('YES') : $this->language->lang('NO'),
					'user_allow_pm'			=> ($row['user_allow_pm'] == true) ? $this->language->lang('YES') : $this->language->lang('NO'),
					'user_allow_viewemail'	=> ($row['user_allow_viewemail'] == true) ? $this->language->lang('YES') : $this->language->lang('NO'),
					'user_allow_viewonline'	=> ($row['user_allow_viewonline'] == true) ? $this->language->lang('YES') : $this->language->lang('NO'),
					'user_avatar'			=> phpbb_get_user_avatar($row),
					'user_avatar_type'		=> ($row['user_avatar_type'] != '') ? $this->language->lang(['avatar_type', $row['user_avatar_type']]) : '',
					'user_birthday'			=> $this->get_birthday($row['user_birthday']),
					'user_dateformat'		=> $this->user->format_date(time(), $row['user_dateformat']),
					'user_email'			=> $row['user_email'],
					'user_emailtime'		=> ($row['user_emailtime'] != 0) ? $this->user->format_date($row['user_emailtime']) : '',
					'user_id'				=> $this->language->lang('HASH') . $row['user_id'],
					'user_inactive_reason'	=> ($row['user_inactive_reason'] != 0) ? $this->language->lang(['inactive_type', $row['user_inactive_reason']]) : '',
					'user_inactive_time'	=> ($row['user_inactive_time'] != 0) ? $this->user->format_date($row['user_inactive_time']) : '',
					'user_ip'				=> $row['user_ip'],
					'user_jabber'			=> $row['user_jabber'],
					'user_lang'				=> $row['user_lang'],
					'user_last_privmsg'		=> ($row['user_last_privmsg'] != 0) ? $this->user->format_date($row['user_last_privmsg']) : '',
					'user_last_search'		=> ($row['user_last_search'] != 0) ? $this->user->format_date($row['user_last_search']) : '',
					'user_lastmark'			=> $this->user->format_date($row['user_lastmark']),
					'user_lastpage'			=> '<a href="' .  generate_board_url() . '/' . $row['user_lastpage'] . '">' . $row['user_lastpage'] . '</a>',
					'user_lastpost_time'	=> ($row['user_lastpost_time'] != 0) ? $this->user->format_date($row['user_lastpost_time']) : '',
					'user_lastvisit'		=> $this->get_last_visit($row['user_id']),
					'user_last_warning'		=> ($row['user_last_warning'] != 0) ? $this->user->format_date($row['user_last_warning']) : '',
					'user_login_attempts'	=> $row['user_login_attempts'],
					'user_new_privmsg'		=> ($row['user_new_privmsg'] != 0) ? $row['user_new_privmsg'] : '',
					'user_notify'			=> ($row['user_notify'] == true) ? $this->language->lang('YES') : $this->language->lang('NO'),
					'user_notify_pm'		=> ($row['user_notify_pm'] == true) ? $this->language->lang('YES') : $this->language->lang('NO'),
					'user_notify_type'		=> $this->language->lang(['notify_type', $row['user_notify_type']]),
					'user_passchg'			=> ($row['user_passchg'] != 0) ? $this->user->format_date($row['user_passchg'] + ($this->config['chg_passforce'] * 86400)) : '',
					'user_posts'			=> $row['user_posts'],
					'user_rank'				=> $user_rank_data['title'],
					'user_regdate'			=> $this->user->format_date($row['user_regdate']),
					'user_sig'				=> generate_text_for_display($row['user_sig'], $row['user_sig_bbcode_uid'], $row['user_sig_bbcode_bitfield'], 7),
					'user_style'			=> $style_name,
					'user_timezone'			=> $this->language->lang(['timezones', $row['user_timezone']]),
					'user_type'				=> $this->language->lang(['user_type', $row['user_type']]),
					'user_unread_privmsg'	=> ($row['user_unread_privmsg'] != 0) ? $row['user_unread_privmsg'] : '',
					'user_warnings'			=> $row['user_warnings'],
				);

				// Get the CPF data for this user
				$sql = $this->db->sql_build_query('SELECT', array(
					'SELECT'	=> 'pfd.*',
					'FROM'		=> array(
						$this->tables['users'] => 'u',
					),
					'LEFT_JOIN'	=> array(
						array(
							'FROM'	=> array($this->tables['profile_fields_data']	=> ' pfd',),
							'ON'	=> 'u.user_id = pfd.user_id',
						),
					),
					'WHERE' => "u.user_id = '" . (int) $row['user_id'] . "'",
				));

				$result 	= $this->db->sql_query($sql);
				$pf_data	= $this->db->sql_fetchrow($result);

				$this->db->sql_freeresult($result);

				foreach ($pf_data as $key => $data)
				{
					// Only process the items that we need
					if ($data && $key != 'user_id')
					{
						$pf_data[$key] = $this->get_pf_data($data, $key);
					}
				}

				// Merge the CPF data and the user data arrays
				$user_vars = array_merge($pf_data, $user_vars);

				// Now let's start the output
				if ($mode == 'csv')
				{
					$csv_data .= '"' . html_entity_decode($row['username']) .'"' . $this->constants['csv_delimiter'];
				}

				$output_data = '';

				foreach ($display_ary as $rows)
				{
					foreach ($this->select_ary as $data)
					{
						if ($data['id'] == $rows)
						{
							$output_data .= '<div class="table-body-cell">' . $user_vars[$data['id']] . '</div>';

							if ($mode == 'csv')
							{
								$csv_data .= '"' . str_replace(array("\r\n","\n","\r")," ",html_entity_decode(strip_tags($user_vars[$data['id']]))) . '"' . $this->constants['csv_delimiter'];
							}
						}
					}
				}

				if ($mode == 'csv')
				{
					$csv_data .= "\n";
				}

				$this->template->assign_block_vars('user_data', array(
					'USERNAME'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
					'OUTPUT_DATA'	=> $output_data,
				));
			}

			if ($mode != 'csv') // Display the output data
			{
				// Count total users for pagination
				$sql = 'SELECT COUNT(u.user_id) AS total_users
					FROM ' . $this->tables['users'] . ' u
					WHERE u.user_type <> ' . USER_IGNORE .
						$filter_by;

				$result 	= $this->db->sql_query($sql);
				$user_count	= (int) $this->db->sql_fetchfield('total_users');

				$this->db->sql_freeresult($result);

				// Swapping ' for " is needed as request will not handle double quotes
				$display_ary = str_replace('"', "'", json_encode($display_ary));

				$action = "{$this->u_action}&amp;sk=$sort_key&amp;sd=$sd&amp;fc=$fc&amp;fb=$fb&amp;disp_ary=$display_ary";

				$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $user_count);
				$this->pagination->generate_template_pagination($action . '&amp;page=page', 'pagination', 'start', $user_count, $this->config['topics_per_page'], $start);

				// Template vars for header panel
				$version_data	= $this->functions->version_check();

				// Are the PHP and phpBB versions valid for this extension?
				$valid = $this->functions->ext_requirements();

				$this->template->assign_vars(array(
					'DOWNLOAD'			=> (array_key_exists('download', $version_data)) ? '<a class="download" href =' . $version_data['download'] . '>' . $this->language->lang('NEW_VERSION_LINK') . '</a>' : '',

					'ERROR_TITLE'		=> $this->language->lang('WARNING'),
					'ERROR_DESCRIPTION'	=> $this->language->lang('ERROR_EXPLAIN'),

					'HEAD_TITLE'		=> $this->language->lang('ACP_USER_DETAILS'),
					'HEAD_DESCRIPTION'	=> $this->language->lang('USER_DETAILS_DISPLAY'),

					'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

					'PHP_VALID' 		=> $valid[0],
					'PHPBB_VALID' 		=> $valid[1],

					'S_BACK'			=> $back,
					'S_ERROR'			=> $error,
					'S_VERSION_CHECK'	=> (array_key_exists('current', $version_data)) ? $version_data['current'] : false,

					'VERSION_NUMBER'	=> $this->functions->get_meta('version'),
				));

				$this->template->assign_vars(array(
					'HEADINGS'		=> $headings,

					'S_FILTER_BY'	=> $this->filter_select($fb, $filter_ary),
					'S_FILTER_CHAR'	=> $this->character_select($fc),
					'S_SORT_DIR'	=> $s_sort_dir,
					'S_SORT_KEY'	=> $s_sort_key,

					'TOTAL_USERS'	=> $user_count,

					'U_ACTION'		=> $action,
				));
			}
			else // Output the csv file
			{
				// Remove any <strong> tags
				$tags 		= array('<strong>', '</strong>');
				$csv_data	= str_replace($tags, '', $csv_data);

				header('Content-Type: application/octet-stream');
				header("Content-disposition: attachment; filename=\"" . basename($filename) . "\"");
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Cache-Control: private', false);
				header('Pragma: public');
				header('Content-Transfer-Encoding: binary');

				fwrite($fp, "\xEF\xBB\xBF"); // UTF-8 BOM
				fwrite($fp, $csv_data);
				fclose($fp);

				// The file has been output so stop
				exit_handler();
			}
		}
	}

	/**
	 * Get the required CPF data
	 *
	 * @return array $pf_fields_array
	 * @access public
	 */
	public function get_cpf_data()
	{
		$sql = 'SELECT pf.field_name, pl.lang_name, pl.lang_explain
			FROM ' . $this->tables['profile_fields'] . ' pf, ' . $this->tables['profile_fields_language'] . ' pl, ' . $this->tables['lang'] . " l
			WHERE pf.field_id  = pl.field_id
				AND pl.lang_id = l.lang_id
				AND pf.field_active = 1
				AND l.lang_iso = '" . (string) $this->user->data['user_lang'] . "'";

		$result	= $this->db->sql_query($sql);

		$pf_fields_array = [];

		while ($row = $this->db->sql_fetchrow($result))
		{
			$pf_fields_array[] = array(
				'id' 		=> 'pf_' . $row['field_name'],
				'attribute' => $row['lang_name'],
				'explain'	=> $row['lang_explain'],
				'filter' 	=> false,
				'cpf' 		=> true,
			);
		}

		$this->db->sql_freeresult($result);

		return $pf_fields_array;
	}

	/**
	 * Get the CPF values
	 *
	 * @param $field_value
	 * @param $field_name
	 *
	 * @return $value
	 * @access public
	 */
	public function get_pf_data($field_value, $field_name)
	{
		// Remove 'pf_' from the field name
		$field_name = substr($field_name, 3);

		// Get the field data
		$sql = $this->db->sql_build_query('SELECT', array(
			'SELECT'	=> 'pf.*, pfl.lang_id',
			'FROM'		=> array(
				$this->tables['profile_fields'] => 'pf',
			),
			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array($this->tables['profile_fields_options_language']	=> ' pfl',),
					'ON'	=> 'pf.field_id = pfl.field_id',
				),
			),
			'WHERE' => "pf.field_name = '" . (string) $field_name . "'",
		));

		$result			= $this->db->sql_query($sql);
		$profile_data	= $this->db->sql_fetchrow($result);

		$this->db->sql_freeresult($result);

		$profile_field = $this->type_collection[$profile_data['field_type']];

		return $profile_field->get_profile_value($field_value, $profile_data);
	}

	/**
	 * Get the user's formatted birthday and age
	 *
	 * @param $birthday
	 *
	 * @return string $birthday_date
	 * @access protected
	 */
	protected function get_birthday($birthday)
	{
		$birthday_date = '';

		if (substr($birthday, 2, 1) == '-')
		{
			list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $birthday));

			$now 	= getdate(time());
			$diff 	= $now['mon'] - $bday_month;

			if ($diff == 0)
			{
				$diff = ($now['mday'] - $bday_day < 0) ? 1 : 0;
			}
			else
			{
				$diff = ($diff < 0) ? 1 : 0;
			}

			$age = (int) ($now['year'] - $bday_year - $diff);

			// Add this check in case there are any strange results
			if ($age < $this->constants['min_age'] || $age > $this->constants['max_age'])
			{
				$birthday_date = '';
			}
			else
			{
				$birthday_date = $bday_day . ' ' . $this->language->lang(['month_types', $bday_month]) . '  ' . $bday_year . ' (' . $age . ')';
			}
		}

		return $birthday_date;
	}

	/**
	 * Get the user's last visit
	 * This is more accurate than user_lastvisit in the user table
	 *
	 * @param $user_id
	 * @return int|mixed|string $last_visit
	 * @access protected
	 */
	protected function get_last_visit($user_id)
	{
		$last_visit 	= '';
		$session_times	= [];

		$sql = 'SELECT session_user_id, MAX(session_time) AS session_time
			FROM ' . $this->tables['sessions'] . '
			WHERE session_time >= ' . (time() - $this->config['session_length']) . '
				AND ' . $this->db->sql_in_set('session_user_id', $user_id) . '
			GROUP BY session_user_id';

		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$session_times[$row['session_user_id']] = $row['session_time'];
		}

		$this->db->sql_freeresult($result);

		$sql = 'SELECT user_lastvisit
			FROM ' . $this->tables['users'] . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_id);

		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$session_time	= (!empty($session_times[$user_id])) ? $session_times[$user_id] : 0;
			if ($row['user_lastvisit'] == 0)
			{
				$last_visit = $this->language->lang('NO_VISIT');
			}
			else
			{
				$last_visit = (!empty($session_time)) ? $session_time : $row['user_lastvisit'];
				$last_visit = $this->user->format_date($last_visit);
			}
		}

		$this->db->sql_freeresult($result);

		return $last_visit;
	}

	/**
	 * Create the filter select
	 *
	 * @param $default
	 * @param $options
	 *
	 * @return string $filter_select
	 * @access protected
	 */
	protected function filter_select($default, $options)
	{
		$filter_select = '<select name="fb" id="fb">';

		foreach ($options as $key => $text)
		{
			$filter_select .= '<option value="' . $key . '"';

			if (isset($default) && $default == $key)
			{
				$filter_select .= ' selected';
			}
			$filter_select .= '>' . $text . '</option>';
		}

		$filter_select .= '</select>';

		return $filter_select;
	}

	/**
	 * Create the character select
	 *
	 * @param $default
	 *
	 * @return string $char_select
	 * @access protected
	 */
	protected function character_select($default)
	{
		$options	 = [];
		$options[''] = $this->language->lang('ALL');

		for ($i = ord($this->language->lang('START_CHARACTER')); $i	<= ord($this->language->lang('END_CHARACTER')); $i++)
		{
			$options[chr($i)] = chr($i);
		}

		$options['other'] 	= $this->language->lang('OTHER');
		$char_select 		= '<select name="fc" id="fc">';

		foreach ($options as $value => $char)
		{
			$char_select .= '<option value="' . $value . '"';

			if (isset($default) && $default == $char)
			{
				$char_select .= ' selected';
			}

			$char_select .= '>' . $char . '</option>';
		}

		$char_select .= '</select>';

		return $char_select;
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		return $this->u_action = $u_action;
	}
}
