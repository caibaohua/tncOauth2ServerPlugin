<?php

/**
 * Base class that represents a row from the 'oauth_authorization_codes' table.
 *
 * 
 *
 * @package    plugins.tncOauth2ServerPlugin.lib.model.om
 */
abstract class BaseOauthAuthorizationCodes extends myBaseObject  implements Persistent {


  const PEER = 'OauthAuthorizationCodesPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        OauthAuthorizationCodesPeer
	 */
	protected static $peer;

	/**
	 * The value for the authorization_code field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $authorization_code;

	/**
	 * The value for the client_id field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $client_id;

	/**
	 * The value for the user_id field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $user_id;

	/**
	 * The value for the redirect_uri field.
	 * @var        string
	 */
	protected $redirect_uri;

	/**
	 * The value for the expires field.
	 * Note: this column has a database default value of: NULL
	 * @var        string
	 */
	protected $expires;

	/**
	 * The value for the scope field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $scope;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Initializes internal state of BaseOauthAuthorizationCodes object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->authorization_code = '';
		$this->client_id = '';
		$this->user_id = 0;
		$this->expires = NULL;
		$this->scope = '';
	}

	/**
	 * Get the [authorization_code] column value.
	 * 
	 * @return     string
	 */
	public function getAuthorizationCode()
	{
		return $this->authorization_code;
	}

	/**
	 * Get the [client_id] column value.
	 * 
	 * @return     string
	 */
	public function getClientId()
	{
		return $this->client_id;
	}

	/**
	 * Get the [user_id] column value.
	 * 
	 * @return     int
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * Get the [redirect_uri] column value.
	 * 
	 * @return     string
	 */
	public function getRedirectUri()
	{
		return $this->redirect_uri;
	}

	/**
	 * Get the [optionally formatted] temporal [expires] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getExpires($format = 'Y-m-d H:i:s')
	{
		if ($this->expires === null) {
			return null;
		}


		if ($this->expires === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->expires);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->expires, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [scope] column value.
	 * 
	 * @return     string
	 */
	public function getScope()
	{
		return $this->scope;
	}

	/**
	 * Set the value of [authorization_code] column.
	 * 
	 * @param      string $v new value
	 * @return     OauthAuthorizationCodes The current object (for fluent API support)
	 */
	public function setAuthorizationCode($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->authorization_code !== $v || $v === '') {
			$this->authorization_code = $v;
			$this->modifiedColumns[] = OauthAuthorizationCodesPeer::AUTHORIZATION_CODE;
		}

		return $this;
	} // setAuthorizationCode()

	/**
	 * Set the value of [client_id] column.
	 * 
	 * @param      string $v new value
	 * @return     OauthAuthorizationCodes The current object (for fluent API support)
	 */
	public function setClientId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->client_id !== $v || $v === '') {
			$this->client_id = $v;
			$this->modifiedColumns[] = OauthAuthorizationCodesPeer::CLIENT_ID;
		}

		return $this;
	} // setClientId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     OauthAuthorizationCodes The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v || $v === 0) {
			$this->user_id = $v;
			$this->modifiedColumns[] = OauthAuthorizationCodesPeer::USER_ID;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [redirect_uri] column.
	 * 
	 * @param      string $v new value
	 * @return     OauthAuthorizationCodes The current object (for fluent API support)
	 */
	public function setRedirectUri($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->redirect_uri !== $v) {
			$this->redirect_uri = $v;
			$this->modifiedColumns[] = OauthAuthorizationCodesPeer::REDIRECT_URI;
		}

		return $this;
	} // setRedirectUri()

	/**
	 * Sets the value of [expires] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     OauthAuthorizationCodes The current object (for fluent API support)
	 */
	public function setExpires($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->expires !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->expires !== null && $tmpDt = new DateTime($this->expires)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					|| ($dt->format('Y-m-d H:i:s') === NULL) // or the entered value matches the default
					)
			{
				$this->expires = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = OauthAuthorizationCodesPeer::EXPIRES;
			}
		} // if either are not null

		return $this;
	} // setExpires()

	/**
	 * Set the value of [scope] column.
	 * 
	 * @param      string $v new value
	 * @return     OauthAuthorizationCodes The current object (for fluent API support)
	 */
	public function setScope($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->scope !== $v || $v === '') {
			$this->scope = $v;
			$this->modifiedColumns[] = OauthAuthorizationCodesPeer::SCOPE;
		}

		return $this;
	} // setScope()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			// First, ensure that we don't have any columns that have been modified which aren't default columns.
			if (array_diff($this->modifiedColumns, array(OauthAuthorizationCodesPeer::AUTHORIZATION_CODE,OauthAuthorizationCodesPeer::CLIENT_ID,OauthAuthorizationCodesPeer::USER_ID,OauthAuthorizationCodesPeer::EXPIRES,OauthAuthorizationCodesPeer::SCOPE))) {
				return false;
			}

			if ($this->authorization_code !== '') {
				return false;
			}

			if ($this->client_id !== '') {
				return false;
			}

			if ($this->user_id !== 0) {
				return false;
			}

			if ($this->expires !== NULL) {
				return false;
			}

			if ($this->scope !== '') {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->authorization_code = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
			$this->client_id = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->user_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->redirect_uri = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->expires = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->scope = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 6; // 6 = OauthAuthorizationCodesPeer::NUM_COLUMNS - OauthAuthorizationCodesPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating OauthAuthorizationCodes object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OauthAuthorizationCodesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = OauthAuthorizationCodesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseOauthAuthorizationCodes:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OauthAuthorizationCodesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			OauthAuthorizationCodesPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseOauthAuthorizationCodes:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseOauthAuthorizationCodes:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OauthAuthorizationCodesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseOauthAuthorizationCodes:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			OauthAuthorizationCodesPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OauthAuthorizationCodesPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += OauthAuthorizationCodesPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = OauthAuthorizationCodesPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OauthAuthorizationCodesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getAuthorizationCode();
				break;
			case 1:
				return $this->getClientId();
				break;
			case 2:
				return $this->getUserId();
				break;
			case 3:
				return $this->getRedirectUri();
				break;
			case 4:
				return $this->getExpires();
				break;
			case 5:
				return $this->getScope();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = OauthAuthorizationCodesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getAuthorizationCode(),
			$keys[1] => $this->getClientId(),
			$keys[2] => $this->getUserId(),
			$keys[3] => $this->getRedirectUri(),
			$keys[4] => $this->getExpires(),
			$keys[5] => $this->getScope(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OauthAuthorizationCodesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setAuthorizationCode($value);
				break;
			case 1:
				$this->setClientId($value);
				break;
			case 2:
				$this->setUserId($value);
				break;
			case 3:
				$this->setRedirectUri($value);
				break;
			case 4:
				$this->setExpires($value);
				break;
			case 5:
				$this->setScope($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OauthAuthorizationCodesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setAuthorizationCode($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setClientId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUserId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRedirectUri($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setExpires($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setScope($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(OauthAuthorizationCodesPeer::DATABASE_NAME);

		if ($this->isColumnModified(OauthAuthorizationCodesPeer::AUTHORIZATION_CODE)) $criteria->add(OauthAuthorizationCodesPeer::AUTHORIZATION_CODE, $this->authorization_code);
		if ($this->isColumnModified(OauthAuthorizationCodesPeer::CLIENT_ID)) $criteria->add(OauthAuthorizationCodesPeer::CLIENT_ID, $this->client_id);
		if ($this->isColumnModified(OauthAuthorizationCodesPeer::USER_ID)) $criteria->add(OauthAuthorizationCodesPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(OauthAuthorizationCodesPeer::REDIRECT_URI)) $criteria->add(OauthAuthorizationCodesPeer::REDIRECT_URI, $this->redirect_uri);
		if ($this->isColumnModified(OauthAuthorizationCodesPeer::EXPIRES)) $criteria->add(OauthAuthorizationCodesPeer::EXPIRES, $this->expires);
		if ($this->isColumnModified(OauthAuthorizationCodesPeer::SCOPE)) $criteria->add(OauthAuthorizationCodesPeer::SCOPE, $this->scope);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OauthAuthorizationCodesPeer::DATABASE_NAME);

		$criteria->add(OauthAuthorizationCodesPeer::AUTHORIZATION_CODE, $this->authorization_code);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     string
	 */
	public function getPrimaryKey()
	{
		return $this->getAuthorizationCode();
	}

	/**
	 * Generic method to set the primary key (authorization_code column).
	 *
	 * @param      string $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setAuthorizationCode($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of OauthAuthorizationCodes (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setAuthorizationCode($this->authorization_code);

		$copyObj->setClientId($this->client_id);

		$copyObj->setUserId($this->user_id);

		$copyObj->setRedirectUri($this->redirect_uri);

		$copyObj->setExpires($this->expires);

		$copyObj->setScope($this->scope);


		$copyObj->setNew(true);

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     OauthAuthorizationCodes Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     OauthAuthorizationCodesPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new OauthAuthorizationCodesPeer();
		}
		return self::$peer;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseOauthAuthorizationCodes:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseOauthAuthorizationCodes::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseOauthAuthorizationCodes
