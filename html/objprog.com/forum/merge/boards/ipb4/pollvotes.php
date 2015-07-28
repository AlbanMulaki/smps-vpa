<?php
/**
 * MyBB 1.8 Merge System
 * Copyright 2014 MyBB Group, All Rights Reserved
 *
 * Website: http://www.mybb.com
 * License: http://www.mybb.com/download/merge-system/license/
 */

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

class IPB4_Converter_Module_Pollvotes extends Converter_Module_Pollvotes {

	var $settings = array(
		'friendly_name' => 'poll votes',
		'progress_column' => 'vid',
		'default_per_screen' => 1000,
	);

	function import()
	{
		global $import_session;

		$query = $this->old_db->simple_select("core_voters", "*", "", array('limit_start' => $this->trackers['start_pollvotes'], 'limit' => $import_session['pollvotes_per_screen']));
		while($pollvote = $this->old_db->fetch_array($query))
		{
			$this->insert($pollvote);
		}
	}

	function convert_data($data)
	{
		global $db;

		$insert_data = array();

		// Invision Power Board 4 values
		$insert_data['uid'] = $this->get_import->uid($data['member_id']);
		$insert_data['dateline'] = $data['vote_date'];

		// Get poll id from thread id
		$query = $db->simple_select("core_polls", "pid", "import_tid = '".$data['tid']."'");
		$insert_data['pid'] = $db->fetch_field($query, "pid");
		$db->free_result($query);

		$choices = unserialize($data['member_choices']);
		$choices = $choices[1];
		foreach($choices as $key => $choice)
		{
			$insert_data['voteoption'] = $choice;

			// We're not going to insert the latest, the insert method will handle that one
			if($key < count($choices)-1)
			{
				$insert_array = $this->prepare_insert_array($insert_data);
				$db->insert_query("pollvotes", $insert_array);
			}
		}

		return $insert_data;
	}

	function fetch_total()
	{
		global $import_session;

		// Get number of poll votes
		if(!isset($import_session['total_pollvotes']))
		{
			$query = $this->old_db->simple_select("core_voters", "COUNT(*) as count");
			$import_session['total_pollvotes'] = $this->old_db->fetch_field($query, 'count');
			$this->old_db->free_result($query);
		}

		return $import_session['total_pollvotes'];
	}
}

?>