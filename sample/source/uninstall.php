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

// remove the WB search feature for sample_dbConnect
if (!$dbSample->sqlRemoveSearchFeature()) {
  $admin->print_error($dbSample->getError()); }

// delete table for sample_dbConnect
if (!$dbSample->sqlDeleteTable()) {
  $admin->print_error($dbSample->getError()); }

?>
