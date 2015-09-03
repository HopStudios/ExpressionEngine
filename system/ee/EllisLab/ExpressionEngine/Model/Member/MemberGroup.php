<?php

namespace EllisLab\ExpressionEngine\Model\Member;

use EllisLab\ExpressionEngine\Service\Model\Model;

class MemberGroup extends Model {

	protected static $_primary_key = 'group_id';
	protected static $_table_name = 'member_groups';

	protected static $_events = array(
		'beforeInsert',
		'afterInsert',
		'afterUpdate'
	);

	protected static $_typed_columns = array(
		'is_locked'                      => 'boolString',
		'can_view_offline_system'        => 'boolString',
		'can_view_online_system'         => 'boolString',
		'can_access_cp'                  => 'boolString',
		'can_access_footer_report_bug'   => 'boolString',
		'can_access_footer_new_ticket'   => 'boolString',
		'can_access_footer_user_guide'   => 'boolString',
		'can_access_publish'             => 'boolString',
		'can_access_edit'                => 'boolString',
		'can_access_files'               => 'boolString',
		'can_access_design'              => 'boolString',
		'can_access_addons'              => 'boolString',
		'can_access_members'             => 'boolString',
		'can_access_sys_prefs'           => 'boolString',
		'can_access_comm'                => 'boolString',
		'can_access_utilities'           => 'boolString',
		'can_access_data'                => 'boolString',
		'can_access_logs'                => 'boolString',
		'can_admin_design'               => 'boolString',
		'can_delete_members'             => 'boolString',
		'can_admin_mbr_templates'        => 'boolString',
		'can_ban_users'                  => 'boolString',
		'can_admin_modules'              => 'boolString',
		'can_edit_categories'            => 'boolString',
		'can_delete_categories'          => 'boolString',
		'can_view_other_entries'         => 'boolString',
		'can_edit_other_entries'         => 'boolString',
		'can_assign_post_authors'        => 'boolString',
		'can_delete_self_entries'        => 'boolString',
		'can_delete_all_entries'         => 'boolString',
		'can_view_other_comments'        => 'boolString',
		'can_edit_own_comments'          => 'boolString',
		'can_delete_own_comments'        => 'boolString',
		'can_edit_all_comments'          => 'boolString',
		'can_delete_all_comments'        => 'boolString',
		'can_moderate_comments'          => 'boolString',
		'can_send_email'                 => 'boolString',
		'can_send_cached_email'          => 'boolString',
		'can_email_member_groups'        => 'boolString',
		'can_email_from_profile'         => 'boolString',
		'can_view_profiles'              => 'boolString',
		'can_edit_html_buttons'          => 'boolString',
		'can_delete_self'                => 'boolString',
		'can_post_comments'              => 'boolString',
		'exclude_from_moderation'        => 'boolString',
		'can_search'                     => 'boolString',
		'can_send_private_messages'      => 'boolString',
		'can_attach_in_private_messages' => 'boolString',
		'can_send_bulletins'             => 'boolString',
		'include_in_authorlist'          => 'boolString',
		'include_in_memberlist'          => 'boolString',
	);

	protected static $_relationships = array(
		'Site' => array(
			'type' => 'belongsTo'
		),
		'Members' => array(
			'type' => 'hasMany',
			'model' => 'Member'
		),
		'AssignedChannels' => array(
			'type' => 'hasAndBelongsToMany',
			'model' => 'Channel',
			'pivot' => array(
				'table' => 'channel_member_groups'
			)
		),
		'AssignedTemplateGroups' => array(
			'type' => 'hasAndBelongsToMany',
			'model' => 'TemplateGroup',
			'pivot' => array(
				'table' => 'template_member_groups',
				'left'  => 'group_id',
				'right' => 'template_group_id'
			)
		),
		'AssignedModules' => array(
			'type' => 'hasAndBelongsToMany',
			'model' => 'Module',
			'pivot' => array(
				'table' => 'module_member_groups'
			)
		),
		'NoTemplateAccess' => array(
			'type' => 'hasAndBelongsToMany',
			'model' => 'Template',
			'pivot' => array(
				'table' => 'template_no_access',
				'right'  => 'template_id',
				'left' => 'member_group'
			)
		),
		'NoUploadAccess' => array(
			'type' => 'hasAndBelongsToMany',
			'model' => 'UploadDestination',
			'pivot' => array(
				'table' => 'upload_no_access',
				'left' => 'member_group',
				'right' => 'upload_id'
			)
		),
		'NoStatusAccess' => array(
			'type' => 'hasAndBelongsToMany',
			'model' => 'Status',
			'pivot' => array(
				'table' => 'status_no_access',
				'left' => 'member_group',
				'right' => 'status_id'
			)
		),
		'ChannelLayouts' => array(
			'type' => 'hasAndBelongsToMany',
			'model' => 'ChannelLayout',
			'pivot' => array(
				'table' => 'layout_publish_member_groups',
				'key' => 'layout_id',
			)
		),
		'EmailCache' => array(
			'type' => 'hasAndBelongsToMany',
			'model' => 'EmailCache',
			'pivot' => array(
				'table' => 'email_cache_mg'
			)
		)
	);

	protected static $_validation_rules = array(
		'group_id' => 'required|integer',
		'site_id'  => 'required|integer',
	);

	// Properties
	protected $group_id;
	protected $site_id;
	protected $group_title;
	protected $group_description;
	protected $is_locked;
	protected $can_view_offline_system;
	protected $can_view_online_system;
	protected $can_access_cp;
	protected $can_access_footer_report_bug;
	protected $can_access_footer_new_ticket;
	protected $can_access_footer_user_guide;
	protected $can_access_publish;
	protected $can_access_edit;
	protected $can_access_files;
	protected $can_access_design;
	protected $can_access_addons;
	protected $can_access_members;
	protected $can_access_sys_prefs;
	protected $can_access_comm;
	protected $can_access_utilities;
	protected $can_access_data;
	protected $can_access_logs;
	protected $can_admin_design;
	protected $can_delete_members;
	protected $can_admin_mbr_templates;
	protected $can_ban_users;
	protected $can_admin_modules;
	protected $can_edit_categories;
	protected $can_delete_categories;
	protected $can_view_other_entries;
	protected $can_edit_other_entries;
	protected $can_assign_post_authors;
	protected $can_delete_self_entries;
	protected $can_delete_all_entries;
	protected $can_view_other_comments;
	protected $can_edit_own_comments;
	protected $can_delete_own_comments;
	protected $can_edit_all_comments;
	protected $can_delete_all_comments;
	protected $can_moderate_comments;
	protected $can_send_email;
	protected $can_send_cached_email;
	protected $can_email_member_groups;
	protected $can_email_from_profile;
	protected $can_view_profiles;
	protected $can_edit_html_buttons;
	protected $can_delete_self;
	protected $mbr_delete_notify_emails;
	protected $can_post_comments;
	protected $exclude_from_moderation;
	protected $can_search;
	protected $search_flood_control;
	protected $can_send_private_messages;
	protected $prv_msg_send_limit;
	protected $prv_msg_storage_limit;
	protected $can_attach_in_private_messages;
	protected $can_send_bulletins;
	protected $include_in_authorlist;
	protected $include_in_memberlist;
	protected $cp_homepage;
	protected $cp_homepage_channel;
	protected $cp_homepage_custom;


	/**
	 * Ensure group ID is set for new records
	 * @return void
	 */
	public function onBeforeInsert()
	{
		if ( ! $this->group_id)
		{
			$id = ee('db')->query('SELECT MAX(group_id) as id FROM exp_member_groups')->row('id');
			$this->setRawProperty('group_id', $id + 1);
		}
	}

	/**
	 * Only set ID if we're being passed a number other than 0 or NULL
	 * @param Integer/String $new_id ID of the record
	 */
	public function setId($new_id)
	{
		if ($new_id !== '0' && $new_id !== 0)
		{
			parent::setId($new_id);
		}
	}

	/**
	 * Ensure member group records are created for each site
	 * @return void
	 */
	public function onAfterInsert()
	{
		$this->setId($this->group_id);

		$sites = $this->getFrontend()->get('Site')
			->fields('site_id')
			->all()
			->pluck('site_id');

		foreach ($sites as $site_id)
		{
			$group = $this->getFrontend()->get('MemberGroup')
				->filter('group_id', $this->group_id)
				->filter('site_id', $site_id)
				->first();

			if ( ! $group)
			{
				$data = $this->getValues();
				$data['site_id'] = (int) $site_id;
				$this->getFrontend()->make('MemberGroup', $data)->save();
			}
		}
	}

	protected function constrainQueryToSelf($query)
	{
		if ($this->isDirty('site_id'))
		{
			throw new LogicException('Cannot modify site_id.');
		}

		$query->filter('site_id', $this->site_id);
		parent::constrainQueryToSelf($query);
	}

	/**
	 * Update common attributes (group_title, group_description, is_locked)
	 * @return void
	 */
	public function onAfterUpdate()
	{
		ee('db')->update(
			'member_groups',
			array(
				'group_title' => $this->group_title,
				'group_description' => $this->group_description,
				'is_locked' => $this->is_locked
			),
			array('group_id' => $this->group_id)
		);
	}
}
