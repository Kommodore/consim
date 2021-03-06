<?php
/**
 * @package ConSim for phpBB3.1
 *
 * @copyright (c) 2015 Marco Candian (tacitus@strategie-zone.de)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace consim\core\entity;

/**
 * Entity
 */
class WorkOutput extends abstractEntity
{
	/**
	 * All of fields of this objects
	 *
	 **/
	protected static $fields = array(
		'id'					=> 'integer',
		'work_id'				=> 'integer',
		'success_threshold'		=> 'integer',
		'asset_id' 				=> 'integer',
		'asset_value'			=> 'integer',
		'asset_name'			=> 'string',
	);

	/**
	 * Some fields must be unsigned (>= 0)
	 **/
	protected static $validate_unsigned = array(
		'id',
		'work_id',
		'success_threshold',
		'asset_id',
		'asset_value',
	);
	/**
	 * The database table the consim user data are stored in
	 * @var string
	 */
	protected $consim_work_output_table;
	protected $consim_asset_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface	$db							Database object
	 * @param string							$consim_work_output_table	Name of the table used to store data
	 * @param string							$consim_asset_table			Name of the table used to store data
	 * @access public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db,
		$consim_work_output_table,
		$consim_asset_table)
	{
		$this->db = $db;
		$this->consim_work_output_table = $consim_work_output_table;
		$this->consim_asset_table = $consim_asset_table;
	}

	/**
	 * Load the data from the database for this object
	 *
	 * @param int $id WorkOutput id
	 * @return WorkOutput $this object for chaining calls; load()->set()->save()
	 * @access public
	 * @throws \consim\core\exception\out_of_bounds
	 */
	public function load($id)
	{
		$sql = 'SELECT o.id, o.work_id, o.success_threshold,
				o.asset_id, o.asset_value, COALESCE(i.name,"") AS asset_name
			FROM ' . $this->consim_work_output_table . ' o
			LEFT JOIN '. $this->consim_asset_table .' i ON i.id = o.asset_id
			WHERE w.id = '.  $id;
		$result = $this->db->sql_query($sql);
		$this->data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($this->data === false)
		{
			throw new \consim\core\exception\out_of_bounds('id');
		}

		return $this;
	}

	/**
	 * Get ID
	 *
	 * @return int ID
	 * @access public
	 */
	public function getId()
	{
		return $this->getInteger($this->data['id']);
	}

	/**
	 * Get Duration
	 *
	 * @return int Duration
	 * @access public
	 */
	public function getWorkId()
	{
		return $this->getString($this->data['work_id']);
	}

	/**
	 * Get successful trials
	 *
	 * @return int Successful Trials
	 * @access public
	 */
	public function getSuccessThreshold()
	{
		return $this->getInteger($this->data['success_threshold']);
	}

	/**
	 * Get Asset ID
	 *
	 * @return int Asset ID
	 * @access public
	 */
	public function getAssetId()
	{
		return $this->getInteger($this->data['asset_id']);
	}

	/**
	 * Get Asset value
	 *
	 * @return int Asset value
	 * @access public
	 */
	public function getAssetValue()
	{
		return $this->getInteger($this->data['asset_value']);
	}

	/**
	 * Get Asset Name
	 *
	 * @return string Asset Name
	 * @access public
	 */
	public function getAssetName()
	{
		return $this->getString($this->data['asset_name']);
	}
}
