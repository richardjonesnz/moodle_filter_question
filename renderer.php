<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Custom renderer class for filter_question
 *
 * @package    filter
 * @subpackage question
 * @copyright  2017 Richard Jones (https://richardnz.net/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class filter_question_renderer extends plugin_renderer_base {

  /**
  *
  * Given a question id, show the preview.php page
  *
  */
  public function get_question($number) {
    global $CFG;
    // What's the most sensible thing to do here?
    // I'm thinking return a popup link to preview.php
    // Todo: add a parameter which is the link text for the question
    // Todo: look at this: https://moodle.org/mod/forum/discuss.php?d=332254

    // I obfuscated the number in the Atto button code, so I need to de-obfuscate here
    // Todo:  Make a set of config params.  If I knew how I could SHA1 hash the question
    //        number into the Moodle database via the Yui button function
    // echo 'obfusc: ' . $number;
    // Pass the obfuscated id to a copy of preview.php
    $url = '/filter/question/preview.php'; 

    // Now the question number will be visible within the link, how to get around that?
    // This will apply whether or not I hash the question nuber
    $link = new moodle_url($url, array('id'=>$number));
    $text = $this->output->action_link($link, get_string('link_text', 'filter_question'), new popup_action('click', $link)); 
    return $text;
  }
}