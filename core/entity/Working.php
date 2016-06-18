<?php
/**
 * @package ConSim for phpBB3.1
 *
 * @copyright (c) 2015 Marco Candian (tacitus@strategie-zone.de)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace consim\core\entity;

/**
 * Entity for a single ressource
 * To Insert a new travelaction
 */
class Working extends Action
{
	/**
	 * All of fields of this objects
	 *
	 **/
	protected static $fields = array(
		'id'						=> 'integer',
		'user_id'					=> 'integer',
		'starttime'					=> 'integer',
		'endtime'					=> 'integer',
		'work_id'					=> 'integer',
		'status'					=> 'boolean',
	);

	/**
	 * Some fields must be unsigned (>= 0)
	 **/
	protected static $validate_unsigned = array(
		'id',
		'user_id',
		'starttime',
		'endtime',
		'work_id',
		'status',
	);

	/**
	 * The database table the consim user data are stored in
	 * @var string
	 */
	protected $consim_action_table;
	protected $consim_user_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface	$db							Database object
	 * @param string								$consim_action_table	Name of the table used to store data
	 * @param string								$consim_user_table		Name of the table used to store data
	 * @access public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db,
								$consim_action_table,
								$consim_user_table)
	{
		$this->db = $db;
		$this->consim_action_table = $consim_action_table;
		$this->consim_user_table = $consim_user_table;
	}

	/**
	 * Don't load this Entity
	 */
	public function load($id) {}

	/**
	 * Insert the Data for the first time
	 *
	 * Will throw an exception if the data was already inserted (call save() instead)
	 *
	 * @return Working $this object for chaining calls; load()->set()->save()
	 * @access public
	 * @throws \consim\core\exception\out_of_bounds
	 */
	public function insert()
	{
		if (!empty($this->data['id']))
		{
			// The data already exists
			throw new \consim\core\exception\out_of_bounds('id');
		}

		// Make extra sure there is no id set
		unset($this->data['id']);

		// Insert the data to the database
		$sql = 'INSERT INTO ' . $this->consim_action_table . ' ' . $this->db->sql_build_array('INSERT', $this->data);
		$this->db->sql_query($sql);

		$this->data['id'] = (int) $this->db->sql_nextid();

		//User is now active
		$sql = 'UPDATE ' . $this->consim_user_table . '
			SET active = 1
			WHERE user_id = ' . $this->data['user_id'];
		$this->db->sql_query($sql);

		return $this;
	}

	/**
	 * Travel done
	 *
	 * @return Travel $this object for chaining calls; load()->set()->save()
	 * @access public
	 * @throws \consim\core\exception\out_of_bounds
	 */
	public function done()
	{
		// TODO: WAS???
		if($this->data['endtime'] > time() || $this->data['status'] === 1)
		{
			throw new \consim\core\exception\out_of_bounds($integer);
		}

		//User is free
		$sql = 'UPDATE ' . $this->consim_action_table . '
			SET status = 1
			WHERE id = ' . $this->data['id'];
		$this->db->sql_query($sql);

		//User is free and at the new location
		$sql = 'UPDATE ' . $this->consim_user_table . '
			SET active = 0, location_id = '. $this->data['end_location_id'] .'
			WHERE user_id = ' . $this->data['user_id'];
		$this->db->sql_query($sql);

		return $this;
	}

	/**
	 * Set work Id
	 *
	 * @param int $work_id
	 * @return Working
	 * @access public
	 */
	public function setWorkId($work_id)
	{
		return $this->setInteger('work_id', $work_id);
	}

	/**
	 * Get work Id
	 *
	 * @return int work_id
	 * @access public
	 */
	public function getWorkId()
	{
		return $this->getInteger($this->data['work_id']);
	}
}