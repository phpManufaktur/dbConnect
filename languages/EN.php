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

define('dbConnect_error_phpVersion',                  '[dbConnect] this class need <strong>PHP Version 5</strong> or greater. Program execution stopped.');
define('dbConnect_error_no_error',                    '[dbConnect] no error');
define('dbConnect_error_database_undefined',          '[dbConnect] Undefined Database.');
define('dbConnect_error_emptyTableName',              '%s [%s] Empty table name, please define table name at first.');
define('dbConnect_error_noFieldDefinitions',          '%s [%s] No field definitions, please define fields for the database.');
define('dbConnect_error_fieldDefinitionsNotChecked',  '[dbConnect] Please call function <strong>checkFieldDefinitions()</strong> before executing SQL Queries.');
define('dbConnect_error_noPrimaryKey',                '%s [%s] Undefined Primary Key, please define a primary key for the table.');
define('dbConnect_error_execQuery',                   '%s [%s] Error while executing SQL Query: %s');
define('dbConnect_error_noPageIDField',               '%s [%s] Please use the function <strong>setField_PageID()</strong> to tell dbConnect which field of your database contains the PAGE_ID.');
define('dbConnect_error_noModuleDirectory',           '%s [%s] Please use the function <strong>setModuleDirectory()</strong> to tell dbConnect the directory of your database.');
define('dbConnect_error_noSearchableFields',          '%s [%s] No searchable fields defined. Use the function <strong>addFieldDefinition()</strong> to define searchable fields.');
define('dbConnect_error_invalidSearchableField',      '%s [%s] The field <strong>%s</strong> is a PAGE_ID or PRIMARY KEY field and not allowed as searchable field. Please remove from searchable fields and try again.');
define('dbConnect_error_recordEmpty',                 '%s [%s] The delivered record is empty (no data to process).');
define('dbConnect_status_fail',                       '<p><strong>MySQL status:</strong> No database connected.</p>');
define('dbConnect_status_report',                     '<p><strong>MySQL status:</strong><br>%s<br>%s</p>');
define('dbConnect_error_csv_file_no_handle',					'<p>[%s - %s] Fuer die CSV Datei <b>%s</b> konnte kein Handle erzeugt werden.</p>');
define('dbConnect_error_csv_no_keys',									'<p>[%s - %s] In der CSV Datei <b>%s</b> wurden keine Spaltenueberschriften gefunden!</p><p>Fuegen Sie Spaltenueberschriften in die CSV ein oder setzen Sie den Schalter <b>$has_header=false</b>.</p>');
define('dbConnect_error_csv_file_put',								'<p>[%s - %s] Fehler beim Schreiben der CSV Datei <b>%s</b>.</p>');

?>