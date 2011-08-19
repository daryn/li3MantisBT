<?php

namespace app\controllers;

use lithium\security\Auth;
use li3_access\security\Access;
use app\models\Issues;
use app\models\Users;
use app\models\Profiles;
use app\models\Settings;
use app\models\Columns;
use lithium\action\DispatchException;

class IssuesController extends \lithium\action\Controller {

	public function index() {
#		$access = Access::check('auth_rbac', Auth::check('default'), $this->request);
#		if(!empty($access)) {
#			$this->redirect($access['redirect']);
#		}

		# @todo modify the fields list to use only configured fields
		$issues = Issues::find( 'all',
			array(
				'fields'=>array(
					'priority','id', 'reporter_id', 'handler_id', 'project_id',
					'severity','status','last_updated','summary'
				),
				'limit' => 10 )
		);
		$settings = Settings::all();
		$columns = Columns::getViewIssuesColumns($settings);
		$columns = Columns::removeDisabled($columns, $settings);

		return compact('issues', 'settings', 'columns' );
	}

	public function view() {
		$issue = Issues::first($this->request->id);
		return compact('issue');
	}

	public function report() {
		$issue = Issues::create();
		$settings = Settings::all();
		$fields = Columns::removeDisabled( $settings->bug_report_page_fields, $settings );
		$currentUser = Users::first(array('conditions'=>array('username'=>'daryn'), 'with'=>'Profiles'));
		$profilesList = Profiles::getOptionsList( $currentUser->profiles );
		$this->set(array(
			'parentId' => $this->request->m_id,
			'projectId' => $this->request->project_id,
			'currentUser' => $currentUser,
			'profilesList' => $profilesList));
		$reportFormOptions = array('id' => 'report-bug-form');
		if (in_array('attachments', $fields)) {
			$reportFormOptions['enctype'] = "multipart/form-data";
		}

		if (($this->request->data) && $issue->save($this->request->data)) {
			$this->redirect(array('Issues::view', 'args' => array($issue->id)));
		}
		return compact('issue', 'settings', 'reportFormOptions', 'fields', 'profilesList' );
	}

	public function edit() {
		$issue = Issues::find($this->request->id);

		if (!$issue) {
			$this->redirect('Issues::index');
		}
		if (($this->request->data) && $issue->save($this->request->data)) {
			$this->redirect(array('Issues::view', 'args' => array($issue->id)));
		}
		return compact('issue');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Issues::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Issues::find($this->request->id)->delete();
		$this->redirect('Issues::index');
	}
}

?>