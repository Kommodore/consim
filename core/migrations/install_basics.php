<?php

/**
*
* @package ConSim for phpBB3.1
* @copyright (c) 2015 Marco Candian (tacitus@strategie-zone.de)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace consim\core\migrations;

class install_basics extends \phpbb\db\migration\migration
{
	var $consim_version = '0.0.1';

	public function effectively_installed()
	{
		return isset($this->config['consim_version']) && version_compare($this->config['consim_version'], $this->consim_version, '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	/**
	* Add columns
	*
	* @return array Array of table schema
	* @access public
	*/
	public function update_schema()
	{
		return array(
			'add_tables'		=> array(
				$this->table_prefix . 'consim_user'	=> array(
					'COLUMNS'		=> array(
						'user_id'				=> array('UINT:8', 0),
						'vorname'				=> array('VCHAR:255', ''),
						'nachname'				=> array('VCHAR:255', ''),
						'geschlecht'			=> array('UINT:8', 0),
						'geburtsland'			=> array('UINT:8', 0),
						'religion'				=> array('UINT:8', 0),
						'haarfarbe'				=> array('UINT:8', 0),
						'augenfarbe'			=> array('UINT:8', 0),
						'besondere_merkmale'	=> array('UINT:8', 0),
						'sprache_tadsowisch'	=> array('UINT:3', 1),
						'sprache_bakirisch'		=> array('UINT:3', 1),
						'sprache_suranisch'		=> array('UINT:3', 1),
						'rhetorik'				=> array('UINT:3', 1),
						'administration'		=> array('UINT:3', 1),
						'wirtschaft'			=> array('UINT:3', 1),
						'technik'				=> array('UINT:3', 1),
						'nahkampf'				=> array('UINT:3', 1),
						'schusswaffen'			=> array('UINT:3', 1),
						'sprengmittel'			=> array('UINT:3', 1),
						'militarkunde'          => array('UINT:3', 1),
						'spionage'				=> array('UINT:3', 1),
						'schmuggel'				=> array('UINT:3', 1),
						'medizin'				=> array('UINT:3', 1),
						'uberlebenskunde'		=> array('UINT:3', 1),
                        'location'              => array('UINT:8', 4),
                        'active'                => array('BOOL', 0),
					),
					'PRIMARY_KEY'	=> array('user_id'),
				),
				$this->table_prefix . 'consim_figure' => array(
					'COLUMNS'		=> array(
						'id'					=> array('UINT:8', null, 'auto_increment'),
						'beschreibung'			=> array('VCHAR:255', ''),
						'wert'					=> array('VCHAR:255', ''),
						'translate'				=> array('VCHAR:255', ''),
					),
					'PRIMARY_KEY'	=> array('id'),
				),
                $this->table_prefix . 'consim_actions' => array(
					'COLUMNS'		=> array(
						'id'					=> array('UINT:8', NULL, 'auto_increment'),
						'user_id'         		=> array('UINT:8', 0),
						'starttime'				=> array('UINT:8', 0),
                        'endtime'               => array('TIMESTAMP', 0),
                        'travel_id'             => array('UINT:8', 0),
                        'status'                => array('BOOL', 0),
					),
					'PRIMARY_KEY'	=> array('id'),
                    'KEYS'			=> array(
						'starttime'       => array('INDEX', 'starttime'),
                        'endtime'         => array('INDEX', 'endtime'),
                        'travel_id'       => array('INDEX', 'travel_id'),
                        'status'          => array('INDEX', 'status'),
					),
				),
			),
			'add_columns'		=> array(
				$this->table_prefix . 'users'		=> array(
						'consim_register'		=> array('BOOL', 0),
				),
			),
		);
	}

    /**
    * Add or update data in the database
    *
    * @return array Array of table data
    * @access public
    */
    public function update_data()
    {
        return array(
            // Set the current version
            array('config.add', array('consim_version', $this->consim_version)),
            array('custom', array(array($this, 'insert_consim_figure'))),
        );
    }

	public function insert_consim_figure()
	{
		$figure_data = array(
			  array('id' => '1','beschreibung' => 'geschlecht','wert' => 'm','translate' => 'MANNLICH'),
			  array('id' => '2','beschreibung' => 'geschlecht','wert' => 'w','translate' => 'WEIBLICH'),
			  array('id' => '3','beschreibung' => 'geburtsland','wert' => 'frt','translate' => 'FRT'),
			  array('id' => '4','beschreibung' => 'geburtsland','wert' => 'bak','translate' => 'BAK'),
			  array('id' => '5','beschreibung' => 'geburtsland','wert' => 'sur','translate' => 'SUR'),
			  array('id' => '6','beschreibung' => 'religion','wert' => 'orthodox','translate' => 'ORTHODOX'),
			  array('id' => '7','beschreibung' => 'religion','wert' => 'katholisch','translate' => 'KATHOLISCH'),
			  array('id' => '8','beschreibung' => 'religion','wert' => 'muslimisch','translate' => 'MUSLIMISCH'),
			  array('id' => '9','beschreibung' => 'religion','wert' => 'atheistisch','translate' => 'ATHEISTISCH'),
			  array('id' => '10','beschreibung' => 'haarfarbe','wert' => 'schwarz','translate' => 'SCHWARZ'),
			  array('id' => '11','beschreibung' => 'haarfarbe','wert' => 'rot','translate' => 'ROT'),
			  array('id' => '12','beschreibung' => 'haarfarbe','wert' => 'hbraun','translate' => 'HELLBRAUN'),
			  array('id' => '13','beschreibung' => 'haarfarbe','wert' => 'dbraun','translate' => 'DUNKELBRAUN'),
			  array('id' => '14','beschreibung' => 'haarfarbe','wert' => 'blond','translate' => 'BLOND'),
			  array('id' => '15','beschreibung' => 'haarfarbe','wert' => 'dblond','translate' => 'DUNKELBLOND'),
			  array('id' => '16','beschreibung' => 'augenfarbe','wert' => 'grun','translate' => 'GRUN'),
			  array('id' => '17','beschreibung' => 'augenfarbe','wert' => 'grau','translate' => 'GRAU'),
			  array('id' => '18','beschreibung' => 'augenfarbe','wert' => 'braun','translate' => 'BRAUN'),
			  array('id' => '19','beschreibung' => 'augenfarbe','wert' => 'gbraun','translate' => 'GRUNBRAUN'),
			  array('id' => '20','beschreibung' => 'augenfarbe','wert' => 'blau','translate' => 'BLAU'),
			  array('id' => '21','beschreibung' => 'augenfarbe','wert' => 'blgrun','translate' => 'BLAUGRUN'),
			  array('id' => '22','beschreibung' => 'augenfarbe','wert' => 'bernstein','translate' => 'BERNSTEIN'),
			  array('id' => '23','beschreibung' => 'besondere_merkmale','wert' => 'keine','translate' => 'KEINE'),
			  array('id' => '24','beschreibung' => 'besondere_merkmale','wert' => 'narbe','translate' => 'NARBE'),
			  array('id' => '25','beschreibung' => 'besondere_merkmale','wert' => 'schmuck','translate' => 'SCHMUCK'),
			  array('id' => '26','beschreibung' => 'besondere_merkmale','wert' => 'deformierung','translate' => 'DEFORMIERUNG'),
			  array('id' => '27','beschreibung' => 'besondere_merkmale','wert' => 'stark_ubergewichtig','translate' => 'STARK_UBERGEWICHTIG'),
		);
		$this->db->sql_multi_insert($this->table_prefix . 'consim_figure', $figure_data);
	}

	/**
	* Drop columns
	*
	* @return array Array of table schema
	* @access public
	*/
	public function revert_schema()
	{
		return array(
			'drop_tables'		=> array(
				$this->table_prefix . 'consim_user',
				$this->table_prefix . 'consim_figure',
                $this->table_prefix . 'consim_actions',
			),
			'drop_columns'	=> array(
				$this->table_prefix . 'users' => array('consim_register'),
			),
		);
	}
}
