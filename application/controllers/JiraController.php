<?php


class JiraController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
//		createJiraIssue("LT","Login","Epic","Test 1234597810");
//		echo getIssue('LT-8');
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
//		delVersion('LT','1.0.1');
//		getComponent('LT');
//		changeProjectAssignee('LT-7','712020:11db78e0-5882-4547-acf1-9baf0250055e');
//		getUserInfo('712020:11db78e0-5882-4547-acf1-9baf0250055e');
//		getAllFieldList();
//		createField();
//		linkIssue('LT-3','LT-7','Relates','Test');
//		getIssueLinkType();
//		getEpicInfo('10002');
//		createProject();
		updateProject();
//		delProject('TP');
	}

}
