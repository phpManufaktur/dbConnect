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
   
  $Id: info.php 23 2010-07-17 01:49:31Z ralf $
 
  VERSION HISTORY:
  
  0.35 - 17.07.10 Added: destructor automaticly closing the database connection
	0.34 - 28.09.09 Changed: checking table definition
	0.33 - 29.05.09 Changed: sqlInsertRecord($data, &$id=-1) optional &$id return last inserted INDEX
	0.32 - 23.05.09 Added: CSV Functions for Import and Export
	0.31 - 23.04.09 Added: sqlTableExists()
	0.30 - 29.12.08 Added: Option to switch decoding of special chars on/off
  0.29 - 29.11.08 Added: sqlFieldExists
	0.28 - 28.11.08 Added: sqlAlterTableAddField, sqlAlterTableChangeField, sqlAlterTableDropField
  0.27 - 01.11.08 Codecleanings
  0.26 - 17.10.08 Changed: dbConnect now uses MySQLi Interface
  0.25 - 30.09.08 Added: getVersion()
  0.24 - 28.09.08 First public release
  0.10 -> 0.23 - 2007-2008, for embedded use only

**/


$module_directory     = 'dbconnect';
$module_name          = 'dbConnect';
$module_function      = 'snippet';
$module_version       = '0.35';
$module_platform      = '2.7.x';
$module_author        = 'Ralf Hertsch, Berlin (Germany)';
$module_license       = 'GNU General Public License';
$module_description   = 'Class for easy use of databases within Website Baker.';
$module_home          = 'http://phpmanufaktur.de/pages/dbconnect.php';
$module_guid          = '76415019-501D-4365-96EB-779D17261994';

?>
