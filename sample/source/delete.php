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

// Load the unit with the required sample class
require_once(WB_PATH.'/modules/'.basename(dirname(__FILE__)).'/class.sample.php');
  
// create a new instance of sample_dbConnect();
$dbSample = new sample_dbConnect();
  
// delete the record from sample_dbConnect table which contain this section_id
$where = array();
$where['section_id'] = $section_id;

if (!$dbSample->sqlDeleteRecord($where)) {
  $admin->prompt_error($dbSample->getError()); }
  
?>
