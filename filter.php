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
 * Basic email protection filter.
 *
 * @package    filter
 * @subpackage question
 * @copyright  2017 Richard Jones (https://richardnz.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 * Based on work by nadavkav ET netvision DooT net DooT il
 */

defined('MOODLE_INTERNAL') || die();
/**
 * This class looks for question tags in Moodle text and
 * replaces them with questions from the question bank.
 * Tags have the format {QUESTION:xxx} where xxx is the id of a question
 * from the bank in the current course.
 */
class filter_question extends moodle_text_filter {

  function filter($text, array $options = array()) {
  global $PAGE;
  // Might need to change these at some point - eg to double curlies
  $START_TAG = '{QUESTION:';
  $END_TAG = '}';

  $renderer = $PAGE->get_renderer('filter_question');

    // Basic tests to avoid work
    if (!is_string($text)) {
      // non string data can not be filtered anyway
      return $text;
    }
    if (strpos($text, '{') === false) {
      // Do a quick check to see if we have curlies
      return $text;
    }

    // There may be a question or questions in here somewhere so continue ...
    // Get the question numbers and positions in the text and call the
    // renderer to deal with them
    $text = filter_question_insert_questions($text, $START_TAG, $END_TAG, $renderer);   

    return $text;
  }

}
/**
*
* function to replace question filter text with actual question
*
* params:  string containing patterns, pattern start, pattern end, renderer
*/
function filter_question_insert_questions($str, $needle, $limit, $renderer) {
  
  $newstring = $str;
  While (strpos($newstring, $needle) !== false) {
    $initpos = strpos($newstring, $needle);
    if ($initpos !== false) {
       $pos = $initpos + strlen($needle);  //get up to string
       $endpos = strpos($newstring, $limit);
       $data = substr($newstring, $pos, $endpos - $pos); // extract question data
       // Todo: add some sanity checks here, trim the string etc
       // The filter text is added by atto button question which does at least
       // parse the number part, so should be OK unless edited by user.
       // echo 'Data: ' . $data;
       // get the link text
       $endlinkpos = strpos($data, '|');
       $linktext = substr($data, 0, $endlinkpos);
       // echo 'link text: ' . $linktext;
       
       // get the obfuscated question number
       $number = substr($data, $endlinkpos + 1, $endpos - $endlinkpos);
       // echo 'q: ' . $number;

       $question = $renderer->get_question($number, $linktext); 
       
       $newstring = substr_replace($newstring, $question, $initpos, $endpos - $initpos + 1);
       $initpos = $endpos + 1;
    }
  }
  return $newstring;
}