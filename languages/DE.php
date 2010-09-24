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

define('dbConnect_error_phpVersion',                  '[dbConnect] Diese Klasse benoetigt <strong>PHP Version 5</strong> oder hoeher. Die Programmausfuehrung wurde gestoppt.');
define('dbConnect_error_no_error',                    '[dbConnect] - kein Fehler -');
define('dbConnect_error_database_undefined',          '[dbConnect] Datenbank nicht definiert.');
define('dbConnect_error_emptyTableName',              '%s [%s] Leerer Tabellenname, bitte legen Sie zunaechst einen Tabellennamen fest.');
define('dbConnect_error_noFieldDefinitions',          '%s [%s] Es fehlen die Feld Definitionen, bitte legen Sie die Felder fuer die Tabelle fest.');
define('dbConnect_error_fieldDefinitionsNotChecked',  '[dbConnect] Bitte rufen Sie die Funktion <strong>checkFieldDefinitions()</strong> auf, bevor Sie SQL Abfragen durchfuehren.');
define('dbConnect_error_noPrimaryKey',                '%s [%s] Kein Primaerschluessel, bitte legen Sie ein Feld mit einem Primaerschluessel an.');
define('dbConnect_error_execQuery',                   '%s [%s] Fehler beim Ausf�hren der SQL Abfrage: %s');
define('dbConnect_error_noPageIDField',               '%s [%s] Bitte verwenden Sie die Funktion <strong>setField_PageID()</strong> um dbConnect mitzuteilen, welches Feld der Tabelle die PAGE_ID enth�lt.');
define('dbConnect_error_noModuleDirectory',           '%s [%s] Bitte verwenden Sie die Funktion <strong>setModuleDirectory()</strong> um dbConnect das zu der Tabelle zugehoerige Modulverzeichnis mitzuteilen.');
define('dbConnect_error_noSearchableFields',          '%s [%s] Es wurden keine Felder festgelegt, die durchsucht werden koennen. Verwenden Sie die Funktion <strong>addFieldDefinition()</strong> um Felder festzulegen, die von der Suchfunktion verwendet werden sollen.');
define('dbConnect_error_invalidSearchableField',      '%s [%s] Das Feld <strong>%s</strong> enthaelt die PAGE_ID oder ist als PRIMARY KEY festgelegt und darf nicht als durchsuchbares Feld festgelegt werden. Bitte entfernen Sie die Zuordnung und versuchen Sie es danach erneut.');
define('dbConnect_error_recordEmpty',                 '%s [%s] Der uebergebene Datensatz ist leer (keine Aktion erforderlich).');
define('dbConnect_status_fail',                       '<p><strong>MySQL Status:</strong> Es ist keine Datenbank verbunden.</p>');
define('dbConnect_status_report',                     '<p><strong>MySQL Status:</strong><br>%s<br>%s</p>');
define('dbConnect_error_csv_file_no_handle',					'<p>[%s - %s] Fuer die CSV Datei <b>%s</b> konnte kein Handle erzeugt werden.</p>');
define('dbConnect_error_csv_no_keys',									'<p>[%s - %s] In der CSV Datei <b>%s</b> wurden keine Spaltenueberschriften gefunden!</p><p>Fuegen Sie Spaltenueberschriften in die CSV ein oder setzen Sie den Schalter <b>$has_header=false</b>.</p>');
define('dbConnect_error_csv_file_put',								'<p>[%s - %s] Fehler beim Schreiben der CSV Datei <b>%s</b>.</p>');

?>