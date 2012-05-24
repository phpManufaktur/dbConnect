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

// template for frontend view
$view_template =
  '<div class="dbconnect">
    <h2>{header}</h2>
    <div class="dbconnect_intro">{intro}</div>
    <table width="90%">
      <colgroup>
        <col width="30%">
        <col width="70%">
      </colgroup>
      <tr>
        <td>&nbsp;</td>
        <td style="font-size:smaller;text-align:right;">{version}</td>
      </tr>
      <tr>
        <td>{label_simple}</td>
        <td>{simple_text}</td>
      </tr>
      <tr>
        <td>{label_html}</td>
        <td>{html_text}</td>
      </tr>
      <tr>
        <td>{label_modified}</td>
        <td>{last_modified}</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">{table_description}</td>
      </tr>
      <tr>
        <td colspan="2">
          <table width="100%">
            <colgroup>
              <col width="20%">
              <col width="16%">
              <col width="16%">
              <col width="16%">
              <col width="16%">
              <col width="16%">
            </colgroup>
            <tr>
              <th>{header_field}</th>
              <th>{header_type}</th>
              <th>{header_null}</th>
              <th>{header_key}</th>
              <th>{header_default}</th>
              <th>{header_extra}</th>
            <tr>
            {description}
          </table>
        </td>
      </tr>
    </table>
  </div>';

// create a new instance of sample_dbConnect();
$dbSample = new sample_dbConnect();

// Select field 'section_id' with value $section_id
$where = array();
$where['section_id'] = $section_id;

// create a empty record as reference for the query result
$data = array();

// select record from database
if (!$dbSample->sqlSelectRecord($where, $data)) {
  // die on SQL error and prompt error message
  die($dbSample->getError()); }

if (sizeof($data) < 1) {
  // error: no data for this $section_id...
  die(sprintf(dbc_error_no_data, $section_id)); }

// show table structure and informations
if (!$dbSample->sqlDescribeTable($description)) {
  die($dbSample->getError()); }
$desc = '';
foreach ($description as $row) {
	$desc .= sprintf( '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
	         $row['Field'], $row['Type'], $row['Null'], $row['Key'], $row['Default'], $row['Extra']); }

$parseArray = array(
  'header'            => dbc_header,
  'intro'             => dbc_intro_frontend,
  'version'           => sprintf('dbConnect v%s', $dbSample->getVersion()),
  'label_simple'      => dbc_label_simple,
  'simple_text'       => $data[0]['simple_text'],
  'label_html'        => dbc_label_html,
  'html_text'         => $data[0]['html_text'],
  'label_modified'    => dbc_label_modified,
  'last_modified'     => date('d.m.Y - H:i:s', $data[0]['last_modified']),
  'table_description' => dbc_table_description,
  'header_field'      => dbc_header_field,
  'header_type'       => dbc_header_type,
  'header_null'       => dbc_header_null,
  'header_key'        => dbc_header_key,
  'header_default'    => dbc_header_default,
  'header_extra'      => dbc_header_extra,
  'description'       => $desc
);

// replace placeholders with variables
foreach ($parseArray as $key => $value) {
  $view_template = str_replace("{".$key."}", $value, $view_template); }
// show completed form...
echo $view_template;



?>
