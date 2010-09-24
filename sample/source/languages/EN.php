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

define('dbc_btn_abort',         'Abort');
define('dbc_btn_save',          'Save');
define('dbc_error_no_data',     'Error: No data available for SECTION_ID <strong>%s</strong>');
define('dbc_header',            'dbConnect SAMPLE');
define('dbc_header_field',      'FIELD');
define('dbc_header_type',       'TYPE');
define('dbc_header_null',       'NULL');
define('dbc_header_key',        'KEY');
define('dbc_header_default',    'DEFAULT');
define('dbc_header_extra',      'EXTRA');
define('dbc_intro',             '<p>This sample demonstrate the easy usage of the module dbConnect.</p><p>The first input field <em>simple text</em> is not allowed to contain any HTML tags and will be automaticly stripped.</p><p>The second field <em>HTML text</em> is allowed to contain any HTML formatting.</p>');
define('dbc_intro_frontend',    '<p>This sample demonstrate the easy usage of the module dbConnect.</p>');
define('dbc_label_html',        'HTML text');
define('dbc_label_modified',    'Last modified');
define('dbc_label_simple',      'Simple Text');
define('dbc_label_status',      'MySQL status');
define('dbc_success',           '<p>The database table was successfully updated</p>');
define('dbc_status_fail',       '<p><strong>MySQL status:</strong> No database connected.</p>');
define('dbc_status_report',     '<p><strong>MySQL status:</strong><br>%s<br>%s</p>');
define('dbc_table_description', 'Table Description');

?>