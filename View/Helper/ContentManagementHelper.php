<?php

/**
 * Content management helper - helps out with rich UI elements
 *
 */
class ContentManagementHelper extends AppHelper {

/**
 * Additional helpers
 *
 * @var array
 */
	public $helpers = array( 'Form', 'Js' );

/**
 * Initialization javascript for rich text editor.
 *
 * @var string
 */
	protected $_richextInitjs = 'new wysihtml5.Editor("%s", { toolbar: "%s", parserRules: wysihtml5ParserRules });';

/**
 * Create a rich text edit field.
 * Note, that currently this requires the full field name (wuth model) to be used in the view.
 *
 * @param string $fieldName The name of the field to output a rich text editor for
 * @param array $options Additional options will be passed to FormHelper::input
 * @returns Rich text editor HTML
 */
	public function richtext($fieldName,$options=array()) {

		$this->setEntity($fieldName,false);
		$id = $this->domId();

		$this->Form->Html->script('BostonConference.wysihtml5-rules',array('inline' => false));
		$this->Form->Html->script('BostonConference.wysihtml5-0.3.0.min',array('inline' => false));

		$toolbar = <<<EOMARKUP
<div id="$id-toolbar" class="wysiwyg-toolbar">
	<a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h3">h3</a>
	<a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h4">h4</a>
  <a data-wysihtml5-command="bold">bold</a>
  <a data-wysihtml5-command="italic">italic</a>
  <a data-wysihtml5-command="insertUnorderedList">ul</a>
  <a data-wysihtml5-command="insertOrderedList">li</a>
  <a data-wysihtml5-command="createLink">link</a>
  <div data-wysihtml5-dialog="createLink" style="display: none;">
    <label>
      Link:
      <input data-wysihtml5-dialog-field="href" value="http://" class="text">
    </label>
    <a data-wysihtml5-dialog-action="save">OK</a> <a data-wysihtml5-dialog-action="cancel">Cancel</a>
  </div>

	<a data-wysihtml5-command="insertImage">insert image</a>
	<div data-wysihtml5-dialog="insertImage" style="display: none;">
	  <label>
		Image:
		<input data-wysihtml5-dialog-field="src" value="http://">
	  </label>
	  <a data-wysihtml5-dialog-action="save">OK</a>
	  <a data-wysihtml5-dialog-action="cancel">Cancel</a>
	</div>

	<a data-wysihtml5-command="undo">undo</a>
    <a data-wysihtml5-command="redo">redo</a>
	<a data-wysihtml5-action="change_view" class="html-view">html</a>
</div>
EOMARKUP;

		$init = $this->Form->Html->scriptBlock(sprintf($this->_richextInitjs,$id,$id.'-toolbar'),array('inline' => true));
		$defaultOptions = array(
			'type' => 'textarea',
			'between' => $toolbar,
			'after' => $init,
			'class' => 'wysiwyg-textarea'
		);

		$options = array_merge($defaultOptions,$options);

		$this->Form->unlockField('_wysihtml5_mode'); // Unlocks a field making it exempt from the SecurityComponent field hashing.
		return $this->Form->input($fieldName,$options);
	}

}
