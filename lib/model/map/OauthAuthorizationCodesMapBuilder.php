<?php


/**
 * This class adds structure of 'oauth_authorization_codes' table to 'flirten' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.tncOauth2ServerPlugin.lib.model.map
 */
class OauthAuthorizationCodesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.tncOauth2ServerPlugin.lib.model.map.OauthAuthorizationCodesMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(OauthAuthorizationCodesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(OauthAuthorizationCodesPeer::TABLE_NAME);
		$tMap->setPhpName('OauthAuthorizationCodes');
		$tMap->setClassname('OauthAuthorizationCodes');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('AUTHORIZATION_CODE', 'AuthorizationCode', 'VARCHAR', true, 100);

		$tMap->addColumn('CLIENT_ID', 'ClientId', 'VARCHAR', false, 80);

		$tMap->addColumn('USER_ID', 'UserId', 'INTEGER', false, 11);

		$tMap->addColumn('REDIRECT_URI', 'RedirectUri', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXPIRES', 'Expires', 'TIMESTAMP', true, null);

		$tMap->addColumn('SCOPE', 'Scope', 'VARCHAR', false, 100);

	} // doBuild()

} // OauthAuthorizationCodesMapBuilder
