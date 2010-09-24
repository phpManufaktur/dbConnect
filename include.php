<?php

/**

  Module for the Open Source CMS Website Baker - http://websitebaker.org 
  (c) 2008 Ralf Hertsch, hertsch@berlin.de, http://phpManufaktur.de 
   
  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  any later version.
  
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
   
  You should have received a copy of the GNU General Public License
  along with this program.  If not, see http://www.gnu.org/licenses/.
  
  PLEASE CHECK THE INFO.PHP FOR VERSION INFORMATIONS AND HISTORY
   
  $Id: include.php 25 2010-07-17 02:20:40Z ralf $
 
**/

if(!file_exists(WB_PATH .'/modules/'.basename(dirname(__FILE__)).'/languages/' .LANGUAGE .'.php')) {
  require_once(WB_PATH .'/modules/'.basename(dirname(__FILE__)).'/languages/EN.php'); }
else {
  require_once(WB_PATH .'/modules/'.basename(dirname(__FILE__)).'/languages/' .LANGUAGE .'.php'); }

// DIE if php Version is wrong
if (floor(phpversion()) < 5) die(dbConnect_error_phpVersion);

if (!class_exists('dbConnect')) {

	class dbConnect extends MySQLi {

    /**
     * Connection informations, HOST, USERNAME, PASSWORD
     * DBNAME, DBPORT and DBSOCKET.
     * By default dbConnect use this for Website Baker
     * predefined connection array.
     * if you want to use dbConnect without WB define a
     * array with these structure an informations and call
     * __construct() with this array.
     *
     * @var array
     */
    private $wb_connect = array(
      'host'      => DB_HOST,
      'username'  => DB_USERNAME,
      'password'  => DB_PASSWORD,
      'dbname'    => DB_NAME,
      'dbport'    => 3306, 
      'dbsocket'  => ''
    );

    // Formatter for error strings
    const error_prompt = '<p>[%s - %s] <strong>%s</strong></p>';
		const error_db_not_connected = 'Database is not connected!';
		
		const engine_myisam			= 'MyISAM';
		const engine_innodb			= 'InnoDB';
		const engine_heap				= 'HEAP';
		
		const charset_latin1		= 'latin1';
		const charset_latin2		= 'latin2';
		const charset_utf8			= 'utf8';
		
		const collate_latin1_bin						= 'latin1_bin';
		const collate_latin1_danish_ci			= 'latin1_danish_ci';
		const collate_latin1_general_ci			= 'latin1_general_ci';
		const collate_latin1_general_cs			= 'latin1_general_cs';
		const collate_latin1_german1_ci 		=	'latin1_german1_ci';
		const collate_latin1_german2_ci			= 'latin1_german2_ci';
		const collate_latin1_spanish_ci			= 'latin1_spanish_ci';
		const collate_latin1_swedish_ci			= 'latin1_swedish_ci';
		const collate_utf8_general_ci				= 'utf8_general_ci';
		const collate_utf8_unicode_ci				= 'utf8_unicode_ci';

    /**
     * Predefined values for dbConnect
     */
    public    $isConnected        = false;
    private   $dbc_error          = ''; 
    private   $tableName          = '';
    private   $module_name        = '';
    private   $module_directory   = '';
    private   $field_PageID       = '';
    private   $field_SectionID    = '';
    private   $field_PrimaryKey   = '';
    private   $simulate           = false;
    private   $sqlcode            = '';
    private		$engine							= self::engine_myisam;
    private 	$charset						= self::charset_utf8;
    private		$collate						= self::collate_utf8_general_ci;
    private		$decode_special_chars = true;				
    protected $fieldDefinition    = array();
    protected $fields             = array();
    protected $searchableFields   = array();
    protected $htmlFields         = array();
    protected $allowedHTMLtags    = '';
    protected $csvMustFields			= array();
    protected $indexFields				= array();
    protected $foreignKeys				= array();
    
    protected $foreignKey = array(
    	'field'						=> '',
    	'foreign_table'		=> '',
    	'foreign_key'			=> ''
    );

    private 	$namedHTMLEntities = array(
  		'£' => '&pound;',
  		'¤' => '&curren;',
  		'¥' => '&yen;',
  		'€' => '&euro;',
  		'¦' => '&brvbar;',
  		'§' => '&sect;',
  		'¨' => '&uml;',
  		'©' => '&copy;',
  		'ª' => '&ordf;',
  		'«' => '&laquo;',
  		'¬' => '&not;',
  		'­' => '&shy;',
  		'®' => '&reg;',
  		'¯' => '&macr;',
  		'°' => '&deg;',
  		'±' => '&plusmn;',
  		'²' => '&sup2;',
  		'³' => '&sup3;',
  		'´' => '&acute;',
  		'µ' => '&micro;',
  		'¶' => '&para;',
  		'·' => '&middot;',
  		'¸' => '&cedil;',
  		'¹' => '&sup1;',
  		'º' => '&ordm;',
  		'»' => '&raquo;',
  		'¼' => '&frac14;',
  		'½' => '&frac12;',
  		'¾' => '&frac34;',
  		'¿' => '&iquest;',
  		'À' => '&Agrave;',
  		'Á' => '&Aacute;',
  		'Â' => '&Acirc;',
  		'Ä' => '&Auml;',
  		'Ã' => '&Atilde;',
      'Å' => '&Aring;',
  		'Æ' => '&AElig;',
  		'Ç' => '&Ccedil;',
  		'È' => '&Egrave;',
  		'É' => '&Eacute;',
  		'Ê' => '&Eirc;',
  		'Ë' => '&Euml;',
  		'Ì' => '&Igrave;',
  		'Í' => '&Iacute;',
  		'Î' => '&Icirc;',
  		'Ï' => '&Iuml;',
  		'Ð' => '&ETH;',
  		'Ñ' => '&Ntilde;',
  		'Ò' => '&Ograve;',
  		'Ó' => '&Oacute;',
  		'Ô' => '&Ocirc;',
  		'Õ' => '&Otilde;',
  		'Ö' => '&Ouml;',
  		'×' => '&times;',
  		'Ø' => '&Oslash;',
  		'Ù' => '&Ugrave;',
  		'Ú' => '&Uacute;',
  		'Û' => '&Ucirc;',
  		'Ü' => '&Uuml;',
  		'Ý' => '&Yacute;',
  		'Þ' => '&Thorn;',
  		'ß' => '&szlig;',
  		'à' => '&agrave;',
  		'á' => '&aacute;',
  		'â' => '&acirc;',
  		'ã' => '&atilde;',
  		'ä' => '&auml;',
  		'å' => '&aring;',
  		'æ' => '&aelig;',
  		'ç' => '&ccedil;',
  		'è' => '&egrave;',
  		'é' => '&eacute;',
  		'ê' => '&ecirc;',
  		'ë' => '&euml;',
  		'ì' => '&igrave;',
  		'í' => '&iacute;',
  		'î' => '&icirc;',
  		'ï' => '&iuml;',
  		'ð' => '&eth;',
  		'ñ' => '&ntilde;',
  		'ò' => '&ograve;',
  		'ó' => '&oacute;',
  		'ô' => '&ocirc;',
  		'õ' => '&otilde;',
  		'ö' => '&ouml;',
  		'÷' => '&divide;',
  		'ø' => '&oslash;',
  		'ù' => '&ugrave;',
  		'ú' => '&uacute;',
  		'û' => '&ucirc;',
  		'ü' => '&uuml;',
  		'ý' => '&yacute;',
  		'þ' => '&thorn;',
  		'ÿ' => '&yuml;',
  		'š' => '&scaron;',
  		'Š' => '&Scaron;'
    );

    /**
     * Initialize dbConnect
     * If you want use dbConnect without Website Baker
     * you must define a array with the needed connection
     * informations - please look above at $wb_connect
     * for more details
     *
     */
    public function __construct($dbc = array()) {
    	$this->setError(dbConnect_error_database_undefined);
      if (empty($dbc)) {
        // assume to use WB Standard Connection
        $dbc = $this->wb_connect; }
      try {
        parent::__construct($dbc['host'],
                            $dbc['username'],
                            $dbc['password'],
                            $dbc['dbname'],
                            $dbc['dbport'],
                            $dbc['dbsocket'] );
        if (mysqli_connect_error()) {
          throw new Exception(mysqli_connect_error());  }
        $this->isConnected = true;
      }
      catch (Exception $except) {
        $this->setError(sprintf(self::error_prompt, __METHOD__, $except->getLine(), $except->getMessage()));
      }
    } // __construct()
		
    /*
     * Close the database connection
     */
    public function __destruct() {
  		if ($this->isConnected) {
  			@$this->close();
    		$this->isConnected = false;
  		}
  	} // __destruct()
  
  
    /**
     * Execute ab query and return the the, if available, by
     * reference &$result.
     *
     * @param STR $query
     * @param ARRAY $result - BOOL FALSE if no result is available
     * @return BOOL
     */
    public function query($query, &$result=false) {
      if (!$this->isConnected) { 
        $this->setError(sprintf(self::error_prompt, __METHOD__, __LINE__, self::error_db_not_connected));
        return false;
      }
      try { 
        $result = parent::query($query); 
        if ($this->error) {
          throw new Exception($this->error); }
        return true;
      }
      catch (Exception $except) {
        $this->setError(sprintf(self::error_prompt, __METHOD__, $except->getLine(), $except->getMessage()));
        return false;
      }
    } // query()

    /**
     * Return a string with MySQL status informations
     * like phpMyAdmin...
     *
     * @return STR
     */
    public function getMySQLstatus() {
      if (!$this->isConnected) {
        return dbConnect_status_fail;
      }
      else {
        return sprintf(dbConnect_status_report, $this->host_info, $this->stat());
      }
    }

    /**
     * Return Version of class dbConnect
     *
     * @return FLOAT
     */
    public function getVersion() {
      // read info.php into array
      $info_text = file(WB_PATH.'/modules/'.basename(dirname(__FILE__)).'/info.php');
      if ($info_text == false) {
        return -1; }
      // walk through array
      foreach ($info_text as $item) {
        if (strpos($item, '$module_version') !== false) {
          // split string $module_version
          $value = split('=', $item);
          // return floatval
          return floatval(ereg_replace('([\'";,\(\)[:space:][:alpha:]])', '', $value[1])); } }
      return -1;
    }

    /**
     * Return true if any error is set
     */
    public function isError() {
      //($this->dbc_error == dbConnect_error_no_error) ? $result = false : $result = true;
     	//return $result;
     	return !($this->dbc_error == dbConnect_error_no_error);
    }

    /**
     * Set $this->error to $error
     *
     * @param STR $error
     */
    public function setError($error) {
      $this->dbc_error = $error; 
    }

    /**
     * Return the last error message
     */
    public function getError() {
      if ($this->isError()) {
        return $this->dbc_error; }
      else {
        return dbConnect_error_no_error; }
    }

    public function resetError() {
      $this->dbc_error = dbConnect_error_no_error;
    }

    /**
     * SET Table Name
     * TABLE_PREFIX will be added automaticly
     *
     * @param STRING $tableName
     */
    public function setTableName($tableName) {
      $this->tableName = $tableName;
    }

    /**
     * Return Table Name including TABLE_PREFIX
     *
     * @return STRING
     */
    public function getTableName() {
      return TABLE_PREFIX. $this->tableName;
    }

    /**
     * SET name of module dbConnect is used for
     *
     * @param STRING $moduleName
     */
    public function setModuleName($moduleName) {
      $this->module_name = $moduleName;
    }

    /**
     * GET name of module dbConnect is used for
     *
     * @return STRING
     */
    public function getModuleName() {
      return $this->module_name;
    }

    /**
     * SET directory of module dbConnect is used for
     *
     * @param STRING $moduleDirectory
     */
    public function setModuleDirectory($moduleDirectory) {
      $this->module_directory = $moduleDirectory;
    }

    /**
     * GET directory of module dbConnect is used for
     *
     * @return STRING
     */
    public function getModuleDirectory() {
      return $this->module_directory;
    }

    /**
     * SET primary key for database
     *
     * @param STRING $primaryKey
     */
    public function setField_PrimaryKey($primaryKey) {
      $this->field_PrimaryKey = $primaryKey;
    }

    /**
     * GET primary key
     *
     * @return STRING
     */
    public function getField_PrimaryKey() {
      return $this->field_PrimaryKey;
    }

    /**
     * SET page_id field for database
     *
     * @param STRING $pageID
     */
    public function setField_PageID($pageID) {
      $this->field_PageID = $pageID;
    }

    /**
     * GET page_id field
     *
     * @return STRING
     */
    public function getField_PageID() {
      return $this->field_PageID;
    }

    /**
     * SET section_id field for database
     *
     * @param STRING $sectionID
     */
    public function setField_SectionID($sectionID) {
      $this->field_SectionID = $sectionID;
    }

    /**
     * GET section_id field
     *
     * @return STRING
     */
    public function getField_SectionID() {
      return $this->field_SectionID;
    }

    /**
     * SET allowed HTML tags
     */
    public function setAllowedHTMLtags($tags) {
      $this->allowedHTMLtags = $tags;
    }

    /**
     * GET allowed HTML tags
     */
    public function getAllowedHTMLtags() {
      return $this->allowedHTMLtags;
    }

    /**
     * Switch the simulation mode on or off
     *
     * @param BOOLEAN $switchON
     */
    public function simulation($switchON) {
      $this->simulate = (boolean) $switchON;
    }

    /**
     * Switch the decoding of special chars on or off
     */
    public function setDecodeSpecialChars($decode=true) {
    	$this->decode_special_chars = $decode;
    }
    
    /**
     * SET SQL Code
     *
     * @param STRING $sqlcode
     */
    public function setSQL($sqlcode) {
      $this->sqlcode = $sqlcode;
    }

    /**
     * GET SQL Code
     *
     * @return STRING
     */
    public function getSQL() {
      return $this->sqlcode;
    }

    /**
     * Execute $sqlCode and return $result if possible
     *
     * @param STRING $sqlCode
     * @param REFERENCE ARRAY $result
     * @return BOOLEAN
     */
    public function sqlExec($sqlCode, &$result) {
      $result = array();
      if ($this->isError()) { return false; }
      $this->setSQL($sqlCode);
      if ($this->simulate) return true;
      try {
        $sql_result = false; 
        if (!$this->query($this->getSQL(), $sql_result)) { 
          throw new Exception($this->getError()); }
        // $sql_result may be boolean or a object...
        if (is_object($sql_result)) {
          $numRows = $sql_result->num_rows;
          if ($numRows > 0) {
            for ($i=0; $i < $numRows; $i++) {
              $result[] = $sql_result->fetch_assoc();
            }
          }
          $sql_result->close();
        } // is_object()
      }
      catch (Exception $except) {
        $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
        return false;  }
      return true;
    }

    /**
     * Define FIELD in Table. Call this function for each field.
     *
     * @param STRING $field Identifer
     * @param STRING $type SQL Definition of Field Type
     * @param BOOLEAN $primaryKey set TRUE if this Field should be the primary key
     * @param BOOLEAN $makeSearchable set TRUE if this Field should be visible for the WB Search function
     * @param BOOLEAN $allowHTML set TRUE if the Field is allowed to contain HTML tags
     */
    public function addFieldDefinition($field, $type, $primaryKey=false, $makeSearchable=false, $allowHTML=false) {
      $this->fieldDefinition[] = array('field' => $field, 'type' => $type);
      $this->fields[$field] = '';
      if ($primaryKey) {
        $this->setField_PrimaryKey($field); }
      if ($makeSearchable) {
        $this->searchableFields[] = $field;  }
      if ($allowHTML) {
        $this->htmlFields[] = $field;  }
      $this->setError(dbConnect_error_fieldDefinitionsNotChecked);
    }

    /**
     * Return the FIELDS of the table
     * 
     * @return ARRAY
     */
    public function getFields() {
      return $this->fields;
    }

    /**
     * Checks the Field Definitions.
     * Call this function after complete call of addFieldDefinition()
     *
     * @return BOOL
     */
    public function checkFieldDefinitions() {
      // empty table name
      if (strlen($this->tableName) == 0) {
        $this->setError(sprintf(dbConnect_error_emptyTableName,__METHOD__, __LINE__));
        return false; }        
      // no field definitions...
      if (count($this->fieldDefinition) < 1) {
        $this->setError(sprintf(dbConnect_error_noFieldDefinitions, __METHOD__, __LINE__));
        return false; }        
      // no primary key
      if (strlen($this->field_PrimaryKey) == 0) {
        $this->setError(sprintf(dbConnect_error_noPrimaryKey, __METHOD__, __LINE__));
        return false;  }        
      // ok - no error switch to  no_error
      $this->resetError(); 
      return true;
    }
    
    public function setIndexFields($index_fields) {
    	$this->indexFields = $index_fields;
    } // setIndexFields
    
    public function getIndexFields() {
    	return $this->indexFields;
    }
    
    public function setForeignKeys($foreign_keys) {
    	$this->foreignKeys = $foreign_keys;
    }
    
    public function getForeignKeys() {
    	return $this->foreignKeys;
    }
    
    public function setEngine($engine) {
    	$this->engine = $engine;
    }
    
    public function getEngine() {
    	return $this->engine;
    }
    
    public function setCharset($charset) {
    	$this->charset = $charset;
    }
    
    public function getCharset() {
    	return $this->charset;
    }
    
    public function setCollate($collate) {
    	$this->collate = $collate;
    }
    
    public function getCollate() {
    	return $this->collate;
    }
    
    public function setDefaultCharset($charset, $collate) {
    	$this->setCharset($charset);
    	$this->setCollate($collate);
    }

    /**
     * Create the Table
     *
     * @return BOOL
     */
    public function sqlCreateTable() {
      // if class has already error status return false and exit
      if ($this->isError()) { return false; }
      $sqlQuery = sprintf('CREATE TABLE IF NOT EXISTS `%s` ( ', $this->getTableName());
      for ($i=0; $i < count($this->fieldDefinition); $i++) {
        $sqlQuery .= sprintf("`%s` %s,", $this->fieldDefinition[$i]['field'], $this->fieldDefinition[$i]['type']);  }
      $sqlQuery .= sprintf('PRIMARY KEY (%s)', $this->getField_PrimaryKey());     
      if (count($this->getIndexFields()) > 0) {
      	$index = '';
      	foreach ($this->getIndexFields() as $field) {
      		if ($field != $this->getField_PrimaryKey()) {
      			(empty($index)) ? $index = $field : $index .= ','.$field;
      		}
      	}  
      	if (!empty($index)) $sqlQuery .= sprintf(',KEY (%s)', $index);
      }
      
      if (count($this->getForeignKeys()) > 0) {
      	$foreign = '';
      	foreach ($this->foreignKeys as $key) {
      		$foreign .= sprintf(',FOREIGN KEY (%s) REFERENCES %s (%s)', $key['field'], $key['foreign_table'], $key['foreign_field']);
      	}
      	$sqlQuery .= $foreign;
      	$this->setEngine('InnoDB');
      }
      $sqlQuery .= sprintf(') ENGINE = %s DEFAULT CHARSET = %s COLLATE = %s', $this->getEngine(), $this->getCharset(), $this->getCollate());
      $this->setSQL($sqlQuery); 
      if ($this->simulate) return true;
      try {
        if (!$this->query($this->getSQL(), $sql_result)) {
          throw new Exception($this->getError());  }
      }
      catch (Exception $e) {
        $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $e->getLine(), $e->getMessage()));
        return false; }
      return true;
    }

    /**
     * DELETE (DROP) the table if exists
     *
     * @return BOOL
     */
    public function sqlDeleteTable() {
      $this->setSQL("DROP TABLE IF EXISTS ".$this->getTableName());
      if ($this->simulate) return true;
      try {
        if (!$this->query($this->getSQL(), $sql_result)) {
          throw new Exception($this->getError());  }
      }
      catch (Exception $except) {
        $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
        return false;  }
      return true;
    }

    /**
     * Add the global search feature for the desired module
     *
     * @return BOOL
     */
    public function sqlAddSearchFeature() {
      global $database;
      /**
       * check if all needed variables are defined
       */
      if (empty($this->tableName)) {
        $this->setError(sprintf(dbConnect_error_emptyTableName, __METHOD__, __LINE__));
        return false; }
      if (empty($this->module_directory)) {
        $this->setError(sprintf(dbConnect_error_noModuleDirectory, __METHOD__, __LINE__));
        return false;  }
      if (empty($this->field_PageID)) {
        $this->setError(sprintf(dbConnect_error_noPageIDField, __METHOD__, __LINE__));
        return false;  }
      // check searchable fields
      if (count($this->searchableFields) < 1) {
        $this->setError(sprintf(dbConnect_error_noSearchableFields, __METHOD__, __LINE__));
        return false;  }
      else {
        for ($i=0; $i < count($this->searchableFields); $i++) {
          if (($this->searchableFields[$i] == $this->field_PageID) || ($this->searchableFields[$i] == $this->field_PrimaryKey)) {
            $this->setError(sprintf(dbConnect_error_invalidSearchableField, __METHOD__, __LINE__, $this->searchableFields[$i]));
            return false;  }
        }}
      // insert info into the search table
      $search_info = array(
        'page_id'         => 'page_id',
        'title'           => 'page_title',
        'link'            => 'link',
        'description'     => 'description',
        'modified_when'   => 'modified_when',
        'modified_by'     => 'modified_by'
      );
      $search_info = serialize($search_info);
      $moduleDirectory = $this->module_directory;
      $tableName = $this->getTableName();
      $fieldPageID = $this->field_PageID;
      $this->setSQL("INSERT INTO " .TABLE_PREFIX ."search (name,value,extra)	VALUES ('module', '$moduleDirectory', '$search_info')");
      if ($this->simulate) {
        $simulateSQL = $this->getSQL();  }
      else {
        try {
          @$database->query($this->getSQL());
          if ($database->is_error()) {
            throw new Exception($database->get_error()); }}
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false;  }
      }
      // Search query start code
      $query_start_code = "SELECT [TP]pages.page_id, [TP]pages.page_title,	[TP]pages.link, [TP]pages.description,
  	                       [TP]pages.modified_when, [TP]pages.modified_by	FROM [TP]$tableName, [TP]pages WHERE ";
      $this->setSQL("INSERT INTO ".TABLE_PREFIX."search (name, value, extra) VALUES ('query_start', '$query_start_code', '$moduleDirectory')");
      if ($this->simulate) {
        $simulateSQL .= " ".$this->getSQL();  }
      else {
        try {
          @$database->query($this->getSQL());
          if ($database->is_error()) {
            throw new Exception($database->get_error()); }}
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false; }
      }
      // Search query body code
      $query_body_code = "";
      for ($i=0; $i < count($this->searchableFields); $i++) {
        if ($i > 0) { $query_body_code .= " OR "; }
        $field = $this->searchableFields[$i];
        $query_body_code .= "[TP]pages.page_id = [TP]$tableName.$fieldPageID AND [TP]$tableName.$field LIKE \'%[STRING]%\' AND [TP]pages.searching = \'1\'";  }
      $this->setSQL("INSERT INTO ".TABLE_PREFIX."search (name, value, extra) VALUES ('query_body', '$query_body_code', '$moduleDirectory')");
      if ($this->simulate) {
        $simulateSQL .= " ".$this->getSQL();  }
      else {
        try {
          @$database->query($this->getSQL());
          if ($database->is_error()) {
            throw new Exception($database->get_error());  }}
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false;  }
      }
      // Search query end code
      $query_end_code = "";
      $this->setSQL("INSERT INTO ".TABLE_PREFIX."search (name, value, extra) VALUES ('query_end', '$query_end_code', '$moduleDirectory')");
      if ($this->simulate) {
        $simulateSQL .= " ".$this->getSQL();
        $this->setSQL($simulateSQL);
        return true;  }
      else {
        try {
          @$database->query($this->getSQL());
          if ($database->is_error()) {
            throw new Exception($database->get_error()); }}
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false; }
      }
      // Insert a blank row in module database for search function to work...
      return true;
    }

    /**
     * Remove the global search feature for the desired module
     *
     * @return BOOL
     */
    public function sqlRemoveSearchFeature() {
      global $database;
      if (empty($this->module_directory)) {
        $this->setError(sprintf(dbConnect_error_noModuleDirectory, __METHOD__, __LINE__));
        return false;  }
      $moduleDirectory = $this->module_directory;
      $this->setSQL("DELETE FROM " .TABLE_PREFIX ."search WHERE name='module' AND value='$moduleDirectory'");
      if ($this->simulate) {
        $simulateSQL = $this->getSQL();  }
      else {
        try {
          @$database->query($this->getSQL());
          if ($database->is_error()) {
            throw new Exception($database->get_error()); }}
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false; }
      }
      $this->setSQL("DELETE FROM " .TABLE_PREFIX ."search WHERE extra='$moduleDirectory'");
      if ($this->simulate) {
        $simulateSQL .= " ".$this->getSQL();
        $this->setSQL($simulateSQL);
        return true;  }
      else {
        try {
          @$database->query($this->getSQL());
          if ($database->is_error()) {
            throw new Exception($database->get_error()); }}
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false; }
      }
      return true;
    }

    /**
     * Encode special chars with html entities
     *
     * @param REFERENCE STR &$string
     * @return STR
     */
    private function encodeSpecialChars(&$string) {
  		foreach ($this->namedHTMLEntities as $key => $value) {
  			$string = str_replace($key, $value, $string);	}
  		return $string;
    } // encodeSpecialChars()

    /**
     * DECODE special chars with html entities
     */
    private function decodeSpecialChars(&$string) {
    	foreach ($this->namedHTMLEntities as $key => $value) {
    		$string = str_replace($value, $key, $string); }
    	return $string;
    } // decodeSpecialChars()

    /**
     * Prepare incoming data by decoding special chars, strip tags
     * and adding slashes...
     */
    public function prepareIncomingData($string, $stripTags=true) {
    	if ($this->decode_special_chars) {
    		$string = $this->decodeSpecialChars($string);
    	}
      if ($stripTags) {
        return addslashes(strip_tags($string)); }
      elseif (empty($this->allowedHTMLtags))  {
        return addslashes($string); }
      else {
        return addslashes(strip_tags($string, $this->allowedHTMLtags));   }
    }

    /**
     * Check the delivered data before transfering to the database
     *
     * @param REFERENCE ARRAY $data
     * @param BOOL $allowPrimaryKey
     * @return BOOL
     */
    public function checkIncomingData(&$data, $allowPrimaryKey=false) {
      // walk through the $data Array an check values
      reset($data);
      $checked = array();
      while (false !== (list($key, $val) = each($data))) {
        if (key_exists($key, $this->fields)) {
          if ($key == $this->field_PrimaryKey) {
            if ($allowPrimaryKey) {
              $checked[$key] = $this->prepareIncomingData($val); }}
          else {
            if (in_array($key, $this->htmlFields)) {
              $checked[$key] = $this->prepareIncomingData($val, false);  }
            else {
              $checked[$key] = $this->prepareIncomingData($val); }
          }
        }
      }
      // replace $record with $data
      $data = $checked;
      // check for errors
      if (count($data) < 1) {
        $this->setError(sprintf(dbConnect_error_recordEmpty, __METHOD__, __LINE__));
        return false; }
      return true;
    }

    /**
     * Insert the $data as new record to the table
     * $data must be transmitted as array in the form:
     * array("field_1" => "value_1", "field_2" => "value_2" [...])
     * Field which is configured as Primary Key will be ignored.
     *
     * @param ARRAY $data
     * @return BOOL
     */
    public function sqlInsertRecord($data, &$id=-1) {
      // check $data first
      if (!$this->checkIncomingData($data)) return false;
      $id = -1;
      $thisQuery = "INSERT INTO ".$this->getTableName()." SET ";
      reset($data);
      $start = true;
      while (list($key, $val) = each($data)) {
        if ($start) { $start = false;  }
        else { $thisQuery .= ","; }
        $thisQuery .= "$key='$val'";
      }
      $this->setSQL($thisQuery);
      if ($this->simulate) { return true; }
      else {
        try {
          if (!$this->query($this->getSQL(), $sql_result)) {
            throw new Exception($this->getError()); }
        }
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false; }
      }
      $id = $this->insert_id;
      return true;
    }

    /**
     * Insert the $data as new record into the table
     * and return the $id of this record
     * 
     * @param ARRAY $data
     * @param REFERENCE INT $id
     * @return BOOL
     */
    /*
    public function sqlInsertRecordGetID($data, &$id) {
    	$id = -1;
    	$result = $this->sqlInsertRecord($data);
    	$id = $this->insert_id;
    	return $result;
    }
    */
    
    /**
     * Update the record $where with the data $data.
     * $data and $where must be transmitted as array in the form:
     * array("field_1" => "value_1", "field_2" => "value_2" [...]).
     * Primary Key will be ignored in $data array.
     *
     * @param ARRAY $data
     * @param ARRAY $where
     * @return BOOL
     */
    public function sqlUpdateRecord($data, $where) {
      // check $data first
      if (!$this->checkIncomingData($data)) return false;
      if (!$this->checkIncomingData($where, true)) return false;
      $thisQuery = "UPDATE ".$this->getTableName()." SET ";
      reset($data);
      $start = true;
      while (list($key, $val) = each($data)) {
        if ($start) { $start = false; }
        else { $thisQuery .= ","; }
        $val = trim($val);
        $thisQuery .= "$key='$val'"; }
      reset($where);
      $start = true;
      $thisQuery .= " WHERE ";
      while (list($key, $val) = each($where)) {
        if ($start) { $start = false; }
        else { $thisQuery .= " AND "; }
        $thisQuery .= "$key='$val'";  }
      $this->setSQL($thisQuery);
      if ($this->simulate) { return true; }
      else {
        try {
          if (!$this->query($this->getSQL(), $sql_result)) {
            throw new Exception($this->getError());  }
        }
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false; }
      }
      return true;
    }

    /**
     * SELECT record(s) matching to $where. Return records in $result
     * $where must be transmitted as array in the form:
     * array("field_1" => "value_1", "field_2" => "value_2" [...]).
     * If $where is empty function return all records in table
     *
     * @param ARRAY $where
     * @param REFERENCE ARRAY $result
     * @return BOOL
     */
    public function sqlSelectRecord($where = array(), &$result = array()) {
      $result = array();
      if (empty($where)) {
        // select All
        $thisQuery = "SELECT * FROM ".$this->getTableName();  }
      else {
        // check $where first
        if (!$this->checkIncomingData($where, true)) return false;
        $thisQuery = "SELECT * FROM ".$this->getTableName()." WHERE ";
        reset($where);
        $start = true;
        while (list($key, $val) = each($where)) {
          if ($start) { $start = false; }
          else { $thisQuery .= " AND "; }
          $thisQuery .= "$key='$val'";  }
      }
      $this->setSQL($thisQuery); 
      if ($this->simulate) { 
      	return true; }
      else {
        try { 
          if (!$this->query($this->getSQL(), $sql_result)) { 
            throw new Exception($this->getError()); } 
        }
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false; }
      }
      $numRows = $sql_result->num_rows; 
      if ($numRows > 0) {
        for ($i=0; $i < $numRows; $i++) {
          $check = $sql_result->fetch_assoc();
          while (list($key, $val) = each($check)) {
            if (key_exists($key, $this->fields)) {
              $result[$i][$key] = stripslashes($val); }
          }
        }
      }
      $sql_result->close();
      return true;
    }

    /**
     * SELECT record(s) matching to $where ORDER BY $orderBy.
     * Return records in $result $where must be transmitted as array in the form:
     * array("field_1" => "value_1", "field_2" => "value_2" [...]).
     * If $where is empty function return all records in table
     * $orderBy must be transmitted as simple array, containing the fieldnames.
     *
     * @param ARRAY $where
     * @param REFERENCE ARRAY $result
     * @param ARRAY $orderBy
     * @param BOOL $ascending
     * @return BOOL
     */
    public function sqlSelectRecordOrderBy($where, &$result, $orderBy, $ascending=true) {
      $result = array();
      if (empty($where)) {
        // select All
        $thisQuery = "SELECT * FROM ".$this->getTableName();
        if (!empty($orderBy)) {
          // ORDER BY
          $start = true;
          $thisQuery .= " ORDER BY ";
          for ($i=0; $i < sizeof($orderBy); $i++) {
            if ($start) { $start = false; }
            else { $thisQuery .= ", "; }
            $thisQuery .= $orderBy[$i]; }
          if ($ascending == true) {
            $thisQuery .= " ASC"; }
          else {
            $thisQuery .= " DESC"; }}
      }
      else {
        // check $where first
        if (!$this->checkIncomingData($where, true)) return false;
        $thisQuery = "SELECT * FROM ".$this->getTableName()." WHERE ";
        reset($where);
        $start = true;
        while (list($key, $val) = each($where)) {
          if ($start) { $start = false; }
          else { $thisQuery .= " AND "; }
          $thisQuery .= "$key='$val'";  }
        if (!empty($orderBy)) {
          // ORDER BY
          $start = true;
          $thisQuery .= " ORDER BY ";
          for ($i=0; $i < sizeof($orderBy); $i++) {
            if ($start) { $start = false; }
            else { $thisQuery .= ", "; }
            $thisQuery .= $orderBy[$i]; }
          if ($ascending == true) {
            $thisQuery .= " ASC"; }
          else {
            $thisQuery .= " DESC"; }}
      }
      $this->setSQL($thisQuery);
      if ($this->simulate) { return true; }
      else {
        try {
          if (!$this->query($this->getSQL(), $sql_result)) {
            throw new Exception($this->getError()); }
        }
        catch (Exception $except) {
          $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
          return false; }
      }
      $numRows = $sql_result->num_rows;
      if ($numRows > 0) {
        for ($i=0; $i < $numRows; $i++) {
          $check = $sql_result->fetch_assoc();
          while (list($key, $val) = each($check)) {
            if (key_exists($key, $this->fields)) {
              $result[$i][$key] = stripslashes($val); }
          }
        }
      }
      $sql_result->close();
      return true;
    }

    /**
     * DELETE record(s) matching to $where.
     * $where must be transmitted as array in the form:
     * array("field_1" => "value_1", "field_2" => "value_2" [...]).
     * ATTENTION: if $where is EMPTY function DELETE ALL RECORDS!!!
     *
     * @param ARRAY $where
     * @return BOOLEAN
     */
    public function sqlDeleteRecord($where) {
      if (empty($where)) {
        // DELETE ALL RECORDS !!!
        $thisQuery = "DELETE FROM ".$this->getTableName();  }
      else {
        // check $where first
        if (!$this->checkIncomingData($where, true)) return false;
        $thisQuery = "DELETE FROM ".$this->getTableName()." WHERE ";
        reset($where);
        $start = true;
        while (list($key, $val) = each($where)) {
          if ($start) { $start = false; }
          else { $thisQuery .= " AND "; }
          $thisQuery .= "$key='$val'";  }}
      $this->setSQL($thisQuery);
      if ($this->simulate) return true;
      try {
        if (!$this->query($this->getSQL(), $sql_result)) {
          throw new Exception($this->getError()); }
        }
      catch (Exception $except) {
        $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
        return false; }
      return true;
    }

    /**
     * DESCRIBE Table, returns $result ARRAY with fields:
     * [Field], [Type], [Null], [Key], [Default] and [Extra]
     * for each entry
     *
     * @param REFERENCE ARRAY $result
     * @return BOOLEAN
     */
    public function sqlDescribeTable(&$result) {
      $this->setSQL("DESCRIBE ".$this->getTableName());
      if ($this->simulate) return true;
      try {
        if (!$this->query($this->getSQL(), $sql_result)) {
          throw new Exception($this->getError()); }
        $numRows = $sql_result->num_rows;
        for ($i=0; $i < $numRows; $i++) {
          $check = $sql_result->fetch_assoc();
          while (list($key, $val) = each($check)) {
            if (!is_numeric($key)) {
              $result[$i][$key] = stripslashes($val); }
          }
        }
        $sql_result->close();
      }
      catch (Exception $except) {
        $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
        return false;  }
      return true;
    }

    /**
     * Check if $field exists in table
     * 
     * @param STR $field
     * @return BOOL
     */
    public function sqlFieldExists($field) {
    	$describe = array();
    	$this->sqlDescribeTable($describe);
    	foreach ($describe as $row) {
    		if ($row['Field'] == $field) {
    			// field already exist - exit
    			return true;	
    		}
    	}
    	return false;
    } // sqlFieldExists()
    
    /**
     * ALTER TABLE and ADD $field with $type
     * If $after_field is empty, the new field will be placed
     * as first field in the table otherwise behind the specified
     * field.
     * Return TRUE on success or if $field already exists
     * 
     * @param STR $field
     * @param STR $type
     * @param STR $after_field
     * @return BOOL
     */
    public function sqlAlterTableAddField($field, $type, $after_field = '') {
    	$describe = array();
    	$this->sqlDescribeTable($describe);
    	foreach ($describe as $row) {
    		if ($row['Field'] == $field) {
    			// field already exist - exit
    			return true;	
    		}
    	}
    	empty($after_field) ? $position = ' FIRST' : $position = 'AFTER '.$after_field;
    	$this->setSQL("ALTER TABLE ".$this->getTableName()." ADD ".$field." ".$type.$position);
    	if ($this->simulate) return true;
    	try {
    		if (!$this->query($this->getSQL())) {
    			throw new Exception($this->getError()); }
    	}
      catch (Exception $except) {
        $this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
        return false;  }
      return true;
    } // sqlAddField()
    
    /**
     * ALTER TABLE and DELETE $field
     * Return TRUE on success or if field does NOT EXISTS
     * 
     * @param STR $field
     * @return BOOL
     */
    public function sqlAlterTableDropField($field) {
    	$describe = array();
    	$this->sqlDescribeTable($describe);
    	foreach ($describe as $row) {
    		if ($row['Field'] == $field) {
    			// Field exists and should be deleted
    			$this->setSQL("ALTER TABLE ".$this->getTableName()." DROP ".$field);
    			if ($this->simulate) return true;
    			try {
    				if (!$this->query($this->getSQL())) {
    					throw new Exception($this->getError());	}
    				else {
    					// success - return true
    					return true;
    				}
    			}
    			catch (Exception $except) {
    				$this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
        		return false;
    			}
    		}
    	}
    	// field not found - return true
    	return true;
    } // sqlAlterTableDeleteField()

    /**
     * ALTER TABLE and CHANGE $old_field
     * Rename to $new_field and set $type 
     * Return TRUE on success or if field does not exists
     * 
     * @param STR $old_field
     * @param STR $new_field
     * @param STR $type
     * @return BOOL
     */
    public function sqlAlterTableChangeField($old_field, $new_field, $type) {
    	$describe = array();
    	$this->sqlDescribeTable($describe);
    	foreach ($describe as $row) {
    		if ($row['Field'] == $old_field) {
    			// field exists and should be modified
    			$this->setSQL("ALTER TABLE ".$this->getTableName()." CHANGE ".$old_field." ".$new_field." ".$type);
    			if ($this->simulate) return true;
    			try {
    				if (!$this->query($this->getSQL())) {
    					throw new Exception($this->getError());	}
    				else {
    					// success - return true
    					return true;
    				}
    			}
    			catch (Exception $except) {
    				$this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
        		return false;
    			}
    		}
    	}
    	// field not found - return true
    	return true;
    } // sqlAlterTableChangeField()
    
    /**
     * Check, if TABLE exists
     * 
     * @return BOOL
     */
    public function sqlTableExists()
    {
    	$this->setSQL(sprintf("SHOW TABLE STATUS LIKE '%s'", $this->getTableName()));
    	if ($this->simulate) return true;
    	try {
    		if (!$this->query($this->getSQL(), $sql_result))
    		{
    			throw new Exception($this->getError());
    		}
    		if ($sql_result->num_rows < 1) 
    		{
    			$result = false;
    		}
    		else {
    			$result = true;
    		}
    		$sql_result->close();
    		return $result;
    	}
    	catch (Exception $except) {
    		$this->setError(sprintf(dbConnect_error_execQuery, __METHOD__, $except->getLine(), $except->getMessage()));
    		return false;
    	}
    } // sqlTableExists()
    
    /**
     * Import CSV File into TABLE.
     * 
     * @param $csvFile_path STR - path to the CSV file
     * @param &$importCSV ARRAY REFERENCE - returns the imported CSV
     * @param $header BOOL TRUE - assume, that 1. line of CSV contain Fielddescriptions
     * @param $duplicates BOOL FALSE - dont import CSV if the record already exists
     * @param $length INT - default 1000
     * @param $delimiter CHAR - default ","
     * @param $enclosure CHAR - default "\""
     * 
     * @return BOOL
     */
    public function csvImport(&$importCSV, $csvFile_path, $header=true, $duplicates=false, $length=1000, $delimiter=",", $enclosure = "\"") {
    	$start = true;
			$key = array();
			$importCSV = array();
			$handle = @fopen ($csvFile_path, "r");
			if ($handle === false) {
				$this->setError(sprintf(dbConnect_error_csv_file_no_handle, __METHOD__, __LINE__, basename($csvFile_path)));
				return false; 
			}
			while (($record = fgetcsv($handle, $length, $delimiter, $enclosure)) !== false) {                                                
    		$num = count($record);
    		$rec = array();
    		for ($i=0; $i < $num; $i++) {
    			if ($start) {
    				if ($header) { 
    					if (array_key_exists($record[$i], $this->fields)) {
    						$key[$i] = $record[$i];		
    					}
    				}
    				else {
    					// kein Header, Datenreihe!
    					$key[$i] = $this->fields[$i];
    					$rec[$key[$i]] = $record[$i]; 	    
    				}
    			}
    			else {
    				if (sizeof($key) < 1) {
    					// Es wurden keine Schluesselfelder erzeugt!
    					$this->setError(sprintf(dbConnect_error_csv_no_keys, __METHOD__, __LINE__, basename($csvFile_path)));
    					return false;
    				}
        		$rec[$key[$i]] = $record[$i];
    		 	}  
				}
    		if ($start) { 
    			$start = false;
    			if (!$header) {
    				$importCSV[] = $rec; 
    			}
    		}
    		else {
    			$importCSV[] = $rec;
    		}
			}
			fclose ($handle);
			foreach ($importCSV as $record) {
				if ($duplicates == false) {
					$data = $record;
					if (key_exists($this->field_PrimaryKey, $data)) {
						unset($data[$this->field_PrimaryKey]);
					}
					$result = array();
					if (!$this->sqlSelectRecord($data, $result)) {
						return false;
					}
					if (sizeof($result) < 1) {
						if (!$this->sqlInsertRecord($record)) {
							return false;
						}
					}
				}
				else {
					if (!$this->sqlInsertRecord($record)) {
						return false;
					}
				}
			}

    	return true;
    } // csvImport()
    
    /**
     * Exports the records matching to $where to the CSV File $csvFile_path
     * 
     * @param $where ARRAY
     * @param &$exportCSV ARRAY REFERENCE matching records exported to CSV
     * @param $csvFile_path STR path to the CSV file
     * @param $header BOOL - default TRUE, write 1. line with field descriptions
     * @param $delimiter CHAR - default ","
     * @param $enclosure CHAR - default "\""
     * 
     * @return BOOL
     */
    public function csvExport($where, &$exportCSV, $csvFile_path, $header=true, $delimiter=",", $enclosure = "\"") {
    	$exportCSV = array();
    	if (!$this->sqlSelectRecord($where, $exportCSV)) {
    		return false;
    	}
    	$handle = @fopen($csvFile_path, "w");
    	if ($handle === false) {
				$this->setError(sprintf(dbConnect_error_csv_file_no_handle, __METHOD__, __LINE__, basename($csvFile_path)));
				return false; 
			}
			$start = true;
			foreach ($exportCSV as $record) {
				if ($start && $header) {
					$head = array();
					foreach ($this->fields as $key => $value) {
						$head[] = $key;
					}
					$bytes = @fputcsv($handle, $head, $delimiter, $enclosure);
					if ($bytes === false) {
						$this->setError(sprintf(dbConnect_error_csv_file_put, __METHOD__, __LINE__,basename($csvFile_path)));
						return false;
					}
					$start = false;
				}
				$bytes = @fputcsv($handle, $record, $delimiter, $enclosure);
				if ($bytes === false) {
					$this->setError(sprintf(dbConnect_error_csv_file_put, __METHOD__, __LINE__,basename($csvFile_path)));
					return false;
				}		
			}
			fclose($handle);
			return true;
    } // csvExport()
    
    public function csvSetMustFields($mustFields=array()) {
    	
    	if (empty($mustFields)) {
    		// Set Defaults
    		$must = $this->fields;
    		unset($must[$this->field_PrimaryKey]);
    		$this->csvMustFields = $must;
    		return true;
    	}
    	else {
    		// use $mustFields
    		$must = array();
    		foreach ($mustFields as $field) { 
    			if ((array_key_exists($field, $this->fields)) && ($field != $this->field_PrimaryKey)) {
    				$must[$field] = ''; 
    			}
    		}
    		if (sizeof($must) > 0) {
    			$this->csvMustFields = $must;
    			return true;
    		} 
    		else {
    			// Set Defaults
    			$must = $this->fields;
    			unset($must[$this->field_PrimaryKey]);
    			$this->csvMustFields = $must;
    			return false;  		
    		}
    	}
    } // csvSetMustFields()
    
    public function csvGetMustFields() {
    	return $this->csvMustFields;
    }
    
   	public function mySQLdate2datum($datetime) {
	    if(strlen($datetime) == 10) {
	      $result = substr($datetime, 8, 2);
	      $result .= ".";
	      $result .= substr($datetime, 5, 2);
	      $result .= ".";
	      $result .= substr($datetime, 0, 4);
	      return $result;
	    }
	    elseif(strlen($datetime) == 19) {
	      $result = substr($datetime, 8, 2);
	      $result .= ".";
	      $result .= substr($datetime, 5, 2);
	      $result .= ".";
	      $result .= substr($datetime, 0, 4);
	      $result .= substr($datetime, 10);
	      return $result;
	    }
	    else {
	      return false;
	    }
		} // mySQLdate2datum()
	
   
  } // dbConnect

} // class_exists()
?>