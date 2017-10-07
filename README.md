# moodle_filter_question
Developing a simple text filter to add a question to Moodle text

Works with moodle_atto_question based on Justin Hunts moodle_atto_template codewhich adds a button to the Atto editor 
allowing a question to be inserted into text.  

The question id is slightly obfuscated and student cannot use the button.

Installation
===========

Filter
place moodle_filter_question files into Moodle filter folder.  
Rename to question.

Atto button
place moodle_atto_question files into Moodle lib/editor/atto/plugin folder.  
Rename to question.

Use the Atto editor config to include your button on the Atto toolbar. 
This is in Site admin | plugind | Text editors | Atto toolbar settings.
For example, add the name question to the list in toolbar config near the bottom, 

eg style1 = title, bold, italic, question

Good luck and shouldn't break anything but buyer beware

Work in progress.
