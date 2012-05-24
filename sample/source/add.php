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

// Load the unit with the required sample class
require_once(WB_PATH.'/modules/'.basename(dirname(__FILE__)).'/class.sample.php');

// create a new instance of sample_dbConnect();
$dbSample = new sample_dbConnect();

// create a new sample record
$data = array();
$data['section_id']     = $section_id;
$data['page_id']        = $page_id;
$data['simple_text']    = 'simple text sample...';
$data['html_text']      = '<p><em>HTML</em> text <strong>sample</strong>...</p>';
$data['last_modified']  = time();

// insert the new record into the sample_dbConnect table
if (!$dbSample->sqlInsertRecord($data)) {
  $admin->print_error($dbSample->getError()); }

?>
