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

if(!file_exists(WB_PATH .'/modules/'.basename(dirname(__FILE__)).'/languages/' .LANGUAGE .'.php')) {
  require_once(WB_PATH .'/modules/'.basename(dirname(__FILE__)).'/languages/EN.php'); }
else {
  require_once(WB_PATH .'/modules/'.basename(dirname(__FILE__)).'/languages/' .LANGUAGE .'.php'); }

// Load the unit with the required sample class
require_once(WB_PATH.'/modules/'.basename(dirname(__FILE__)).'/class.sample.php');

// Template with placeholders for all needed variables
$modify_form =
  '<div class="dbconnect">
    <form name="ps_adresse_modify" action="{form_action}" method="post">
    <input type="hidden" name="page_id" value="{page_id}">
    <input type="hidden" name="section_id" value="{section_id}">
    <input type="hidden" name="action" value="update">
    <h2>{header}</h2>
    <div class="dbconnect_intro">{intro}</div>
    <table width="100%">
      <colgroup>
        <col width="20%">
        <col width="80%">
      </colgroup>
      <tr>
        <td>&nbsp;</td>
        <td style="font-size:smaller;text-align:right;">{version}</td>
      </tr>
      <tr>
        <td>{label_status}</td>
        <td>{status}</td>
      </tr>
      <tr>
        <td>{label_simple}</td>
        <td><input style="width:100%;" type="text" name="simple_text" value="{simple_text}"></td>
      </tr>
      <tr>
        <td>{label_html}</td>
        <td><input style="width:100%;" type="text" name="html_text" value="{html_text}"></td>
      </tr>
      <tr>
        <td>{label_modified}</td>
        <td>{last_modified}
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
          <input type="submit" name="submit" value="{btn_save}">&nbsp;
          <input name="ps_abort" type="button" value="{btn_abort}" onclick="javascript: window.location = \'{abort_location}\'; return false;"/>
        </td>
      </tr>
    </table>
    </form>
  </div>';

// create a new instance of sample_dbConnect();
$dbSample = new sample_dbConnect();


if ((isset($_REQUEST['action'])) && ($_REQUEST['action'] == 'update')) {
  /**
   * the form has changed, take the values to the table...
   */
  // Selection criteria for the record to update is the section_id
  $where = array();
  $where['section_id'] = $section_id;
  // create a empty record and insert the values
  $data = array();
  isset($_REQUEST['simple_text']) ? $data['simple_text']  = $_REQUEST['simple_text']  : $data['simple_text'] = '';
  isset($_REQUEST['html_text'])   ? $data['html_text']    = $_REQUEST['html_text']    : $data['html_text'] = '';
  $data['last_modified'] = time();
  // update the table
  if (!$dbSample->sqlUpdateRecord($data, $where)) {
    $admin->print_error($dbSample->getError()); }
  // Show success message
  $intro = dbc_success;
}
else {
  // first call of the form, show the introduction
  $intro = dbc_intro;
}

// tell dbConnect which fields should be selected
$where = array();
$where['section_id'] = $section_id;

// create an empty record which should contain the referenced data from table...
$data = array();

if (!$dbSample->sqlSelectRecord($where, $data)) {
  // error while executing SQL, prompt error...
  $admin->print_error($dbSample->getError()); }

if (sizeof($data) < 1) {
  // error: no data for this $section_id...
  $admin->print_error(sprintf(dbc_error_no_data, $section_id)); }

/**
 * &$data contains the result of the SQL query and could contain more than only one record,
 * therefore the structure of &$data is a multidimensional array with the structure:
 *
 * $data = array([0] => array([field_1] => value_1 [field_2] => value_2) [1] => array( ... ) ... )
 */

// assign variables to placeholders of the template
$parseArray = array(
  'form_action'     => WB_URL.'/admin/pages/modify.php?page_id='.$page_id,
  'page_id'         => $page_id,
  'section_id'      => $section_id,
  'header'          => dbc_header,
  'version'         => sprintf('dbConnect v%s', $dbSample->getVersion()),
  'intro'           => $intro,
  'label_status'    => dbc_label_status,
  'status'          => $dbSample->getMySQLstatus(),
  'label_simple'    => dbc_label_simple,
  'simple_text'     => $data[0]['simple_text'],
  'label_html'      => dbc_label_html,
  'html_text'       => $data[0]['html_text'],
  'label_modified'  => dbc_label_modified,
  'last_modified'   => date('d.m.Y - H:i:s', $data[0]['last_modified']),
  'btn_save'        => dbc_btn_save,
  'btn_abort'       => dbc_btn_abort,
  'abort_location'  => WB_URL.'/admin/pages/index.php'
);

// replace placeholders with variables
foreach ($parseArray as $key => $value) {
	$modify_form = str_replace("{".$key."}", $value, $modify_form); }
// show completed form...
echo $modify_form;
?>
