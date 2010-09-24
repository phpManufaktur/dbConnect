<?php

/**
  Module developed for the Open Source Content Management System Website Baker (http://websitebaker.org)
  Copyright (c) 2008, Ralf Hertsch
  Contact me: hertsch(at)berlin.de, http://ralf-hertsch.de

  This module is free software. You can redistribute it and/or modify it
  under the terms of the GNU General Public License  - version 2 or later,
  as published by the Free Software Foundation: http://www.gnu.org/licenses/gpl.html.

  This module is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
**/

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