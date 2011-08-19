<?php
namespace app\extensions\helper;

class Form extends \lithium\template\helper\Form {
	protected $_strings = array(
		'button'               => '<input type="{:type}"{:options} />',
		'checkbox'             => '<input type="checkbox" name="{:name}"{:options} />',
		'checkbox-multi'       => '<input type="checkbox" name="{:name}[]"{:options} />',
		'checkbox-multi-end'   => '',
		'checkbox-multi-start' => '',
		'error'                => '<div{:options}>{:content}</div>',
		'errors'               => '{:content}',
		'element'              => '<input type="{:type}" name="{:name}"{:options} />',
		'file'                 => '<input type="file" name="{:name}"{:options} />',
		'form'                 => '<form action="{:url}"{:options}>{:append}',
		'form-end'             => '</form>',
		'hidden'               => '<input type="hidden" name="{:name}"{:options} />',
		'plain-field'          => '{:label}{:input}{:error}',
		'field'                => '<div{:wrap} class="field-container">{:label}<span class="input">{:input}{:error}</span><span class="label-style"></span></div>',
		'field-checkbox'       => '<div{:wrap} class="field-container">{:input}{:label}{:error}<span class="label-style"></span></div>',
		'field-radio'          => '<div{:wrap} class="field-container">{:label}<span class="input">{:input}</span>{:error}<span class="label-style"></span></div>',
		'field-hidden'         => '{:input}',
		'label'                => '<label for="{:name}"{:options}><span>{:title}</span></label>',
		'legend'               => '<legend>{:content}</legend>',
		'option-group'         => '<optgroup label="{:label}"{:options}>',
		'option-group-end'     => '</optgroup>',
		'password'             => '<input type="password" name="{:name}"{:options} />',
		'radio'                => '<input type="radio" name="{:name}" {:options} />',
		'select-start'         => '<select name="{:name}"{:options}>',
		'select-multi-start'   => '<select name="{:name}[]"{:options}>',
		'select-empty'         => '<option value=""{:options}>&nbsp;</option>',
		'select-option'        => '<option value="{:value}"{:options}>{:title}</option>',
		'select-end'           => '</select>',
		'plain-submit'         => '<input type="submit" value="{:title}"{:options} />',
		'submit'               => '<span class="submit-button"><input type="submit" value="{:title}"{:options} /></span>',
		'submit-image'         => '<input type="image" src="{:url}"{:options} />',
		'text'                 => '<input type="text" name="{:name}"{:options} />',
		'textarea'             => '<textarea name="{:name}"{:options}>{:value}</textarea>',
		'fieldset'             => '<fieldset{:options}>{:content}</fieldset>',
		'fieldset-start'       => '<fieldset><legend>{:content}</legend>',
		'fieldset-end'         => '</fieldset>'
	);
}

?>