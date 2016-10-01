<?php
/**
 * @package ConSim for phpBB3.1
 *
 * @copyright (c) 2015 Marco Candian (tacitus@strategie-zone.de)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace consim\core\service;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Operator for Inventory
 */
class UserService
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var ContainerInterface */
	protected $container;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface		$db							Database object
	 * @param ContainerInterface					$container					Service container interface
	 * @access public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db,
		ContainerInterface $container)
	{
		$this->db = $db;
		$this->container = $container;
	}
}