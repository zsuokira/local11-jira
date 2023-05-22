<?php


class JiraController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
//		createJiraIssue("LT","test 3","Bug","Test 1234597810");
//		echo getIssue('LT-1');
//		deleteIssues('LT-5');
//		createLogwork('LT-1','5h 30m');
//		getLogwork('LT-1');
//		addComment('LT-2','Comment test 2');
//		getComment('LT-2');
//		getCommentByID('LT-2','10010');
//		updateComment('LT-2','10010','Comment update 2');
//		delComment('LT-2','10010');
//		setTransition('LT-3','DONE','Chuyển trạng thái');
//	    searchAdvancedSQL('Project in (LT) and status in (Done)');
//		getAllPriority();
//		getPriority(1);
//		createVersion('LT','1.0.0','Test');
//		getVersionRelatedIssues('LT','1.0.0');
//		getVersionUnrelatedIssues('LT','1.0.0');
//		updateVersion('LT','1.0.0','1.0.1','Update test');
		delVersion('LT','1.0.1');
	}

}
