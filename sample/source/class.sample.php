<?php

/**
 * dbConnect
 *
 * @author Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @link https://addons.phpmanufaktur.de/de/addons/dbconnect.php
 * @copyright 2007-2012 phpManufaktur by Ralf Hertsch
 * @license http://www.gnu.org/licenses/gpl.html GNU Public License (GPL)
 */

// prevent this file from being accesses directly
if(defined('WB_PATH') == false) {
  exit("Cannot access this file directly"); }

if (!class_exists('dbConnect')) {
  // the class dbConnect does not exists, try to load class
  if (file_exists(WB_PATH.'/modules/dbconnect/include.php')) {
    require_once(WB_PATH.'/modules/dbconnect/include.php'); }
  else {
    // class is not available
    die("Program execution stopped: This module needs the class dbConnect, please install and try again.");  } }

class sample_dbConnect extends dbConnect {

  public function __construct() {
    parent::__construct();
    $this->setTableName('mod_sample_dbconnect');
    $this->setModuleDirectory('dbconnect_sample');
    $this->setModuleName('dbConnect SAMPLE');
    $this->addFieldDefinition('id',             "INT(11) NOT NULL AUTO_INCREMENT", true);
    $this->addFieldDefinition('section_id',     "INT(11) NOT NULL DEFAULT '0'");
    $this->addFieldDefinition('page_id',        "INT(11) NOT NULL DEFAULT '0'");
    $this->addFieldDefinition('simple_text',    "VARCHAR(255) NOT NULL DEFAULT ''", false, true);
    $this->addFieldDefinition('html_text',      "VARCHAR(255) NOT NULL DEFAULT ''", false, true, true);
    $this->addFieldDefinition('last_modified',  "INT(11) NOT NULL DEFAULT '0'");
    $this->setField_PageID('page_id');
    $this->setField_SectionID('section_id');
    $this->setAllowedHTMLtags('<p><i><b><em><strong>');
    $this->checkFieldDefinitions();
  } // __construct()

} // class sample_dbConnect
?>