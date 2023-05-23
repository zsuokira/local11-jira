<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\Worklog;
use JiraRestApi\Issue\Transition;
use JiraRestApi\Issue\Comment;
use JiraRestApi\Priority\PriorityService;
use JiraRestApi\Issue\Version;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\Version\VersionService;
use JiraRestApi\Component\ComponentService;
use JiraRestApi\User\UserService;
use JiraRestApi\Field\Field;
use JiraRestApi\Field\FieldService;
use JiraRestApi\IssueLink\IssueLink;
use JiraRestApi\IssueLink\IssueLinkService;

// lấy ra 1 issue
if ( ! function_exists('getIssue'))
{
	function getIssue($issueKey)
	{
		$issueService = new IssueService();
		$issue = $issueService->get($issueKey);

		return $issue->fields->summary;
	}
}
//tạo 1 issue
if (!function_exists('createJiraIssue')) {
	function createJiraIssue($projectKey,$summary,$issueType,$description) {
		$issueField = new IssueField();
		$issueField->setProjectKey($projectKey)
			->setSummary($summary)
			->setIssueTypeAsString($issueType)
			->setDescription($description)
		;
		$issueService = new IssueService();
		$ret = $issueService->create($issueField);
		echo "Jira issue create success!";
	}
}
//thêm 1 tệp đính kèm
if (!function_exists('addAttachments')) {
	function addAttachments($issueKey, $att)
	{
		$issueService = new IssueService();
		$ret = $issueService->addAttachments($issueKey, $att);
		print_r($ret);
	}
}
//cập nhật 1 issue
if (!function_exists('updateIssue')) {
	function updateIssue($issueKey,$assigneeName,$issueType,$lable,$description)
	{
		$issueField = new IssueField(true);
		$issueField->setAssigneeNameAsString($assigneeName)
					->setIssueTypeAsString($issueType)
					->addLabel($lable)
					->setDescription($description)
			;
		$editParams = [
			'notifyUsers' => false,
		];
		$issueService = new IssueService();
		$ret = $issueService->update($issueKey, $issueField, $editParams);
		echo "Jira issue create success!";
	}
}
//xoá 1 issue
if (!function_exists('deleteIssues')) {
	function deleteIssues($issueKey)
	{
		$issueService = new IssueService();
		$ret = $issueService->deleteIssue($issueKey);
		// if you want to delete issues with sub-tasks
		//$ret = $issueService->deleteIssue($issueKey, array('deleteSubtasks' => 'true'));
		echo "Jira delete issue success!";
	}
}
//tạo 1 logwork
if (!function_exists('createLogwork')) {
	function createLogwork($issueKey,$timeSpent)
	{
		$issueService = new IssueService();
		$worklog = new Worklog();
		$worklog->setComment('This is a worklog comment'); // nội dung nhật ký công việc
		$worklog->setTimeSpent($timeSpent); // thời gian đã làm việc
		$worklog->setStarted('2023-05-18T10:00:00.000+0000'); // thời gian bắt đầu làm việc
		$response = $issueService->addWorklog($issueKey,$worklog);
		// in thông tin phản hồi từ server
		print_r($response);

	}
}
//lấy 1 logwork
if (!function_exists('getLogwork')) {
	function getLogwork($issueKey)
	{
		$issueService = new IssueService();
		$worklogs = $issueService->getWorklog($issueKey)->getWorklogs();
		var_dump($worklogs);
	}
}
// set transition
if (!function_exists('setTransition')) {
	function setTransition($issueKey,$name,$comment)
	{
		$transition = new Transition();
		$transition->setTransitionName($name);
		$transition->setCommentBody($comment);
		$issueService = new IssueService();
		$issueService->transition($issueKey, $transition);
		echo "Success!";
	}
}

// add Comment
if (!function_exists('addComment')) {
	function addComment($issueKey,$commentValue)
	{
		$comment = new Comment();
		$body = $commentValue;
		$comment->setBody($body);
		$issueService = new IssueService();
		$ret = $issueService->addComment($issueKey, $comment);
		echo "Add comment success";
	}
}
//get comment
if (!function_exists('getComment')) {
	function getComment($issueKey)
	{
		$issueService = new IssueService();

		$param = [
			'startAt' => 0,
			'maxResults' => 3,
			'expand' => 'renderedBody',
		];
		$comments = $issueService->getComments($issueKey, $param);
		print_r($comments);
	}
}
// get comment by id
if (!function_exists('getCommentByID')) {
	function getCommentByID($issueKey,$id)
	{

		$issueService = new IssueService();

		$param = [
			'startAt' => 0,
			'maxResults' => 3,
			'expand' => 'renderedBody',
		];
		$commentId = $id;

		$comments = $issueService->getComment($issueKey, $commentId, $param);

		print_r($comments);

	}
}
//delete comment
if (!function_exists('delComment')) {
	function delComment($issueKey,$id)
	{
		$issueService = new IssueService();
		$ret = $issueService->deleteComment($issueKey, $id);
		echo "Delete success!";
	}
}
// Update comment
if (!function_exists('updateComment')) {
	function updateComment($issueKey,$id,$body)
	{
		$issueService = new IssueService();
		$comment = new Comment();
		$comment->setBody($body);
		$issueService->updateComment($issueKey, $id, $comment);
		echo "Update comment success!";
	}
}

// advanced search
if (!function_exists('searchAdvancedSQL')) {
	function searchAdvancedSQL($jql)
	{
		$issueService = new IssueService();
		$ret = $issueService->search($jql);
		var_dump($ret);
	}
}

//priority
if (!function_exists('getAllPriority')) {
	function getAllPriority()
	{
		$ps = new PriorityService();
		$p = $ps->getAll();
		var_dump($p);
	}
}

if (!function_exists('getPriority')) {
	function getPriority($id)
	{
		$ps = new PriorityService();
		$p = $ps->get($id);
		var_dump($p);
	}
}

//version
if (!function_exists('createVersion')) {
	function createVersion($proj,$ver,$desc)
	{
		$projectService = new ProjectService();
		$project = $projectService->get($proj);
		$versionService = new VersionService();
		$version = new Version();
		$version->setName($ver)
			->setDescription($desc)
			->setReleased(true)
			->setStartDateAsDateTime(new \DateTime())
			->setReleaseDateAsDateTime((new \DateTime())->add(date_interval_create_from_date_string('1 months 3 days')))
			->setProjectId($project->id)
		;
		$res = $versionService->create($version);
		var_dump($res);
	}
}

if (!function_exists('updateVersion')) {
	function updateVersion($proj,$ver,$updateVer,$desc)
	{
		$versionService = new VersionService();
		$projectService = new ProjectService();
		$ver = $projectService->getVersion($proj,$ver);
		//update
		$ver->setName($updateVer)
			->setDescription($desc)
			->setReleased(false)
			->setStartDateAsDateTime(new \DateTime())
			->setReleaseDateAsDateTime((new \DateTime())->add(date_interval_create_from_date_string('2 weeks 3 days')))
		;
		$res = $versionService->update($ver);
		var_dump($res);
	}
}

if (!function_exists('delVersion')) {
	function delVersion($proj,$ver)
	{
		$versionService = new VersionService();
		$projectService = new ProjectService();
		$version = $projectService->getVersion($proj, $ver);
		$res = $versionService->delete($version);
		echo "Delete version success!!!";
	}
}
//get version giải quyết đc issue
if (!function_exists('getVersionRelatedIssues')) {
	function getVersionRelatedIssues($proj,$ver)
	{
		$versionService = new VersionService();
		$projectService = new ProjectService();
		$version = $projectService->getVersion($proj, $ver);
		$res = $versionService->getRelatedIssues($version);
		var_dump($res);
	}
}
//get version chưa giải quyết đc issue
if (!function_exists('getVersionUnrelatedIssues')) {
	function getVersionUnrelatedIssues($proj,$ver)
	{
		$versionService = new VersionService();
		$projectService = new ProjectService();
		$version = $projectService->getVersion($proj, $ver);
		$res = $versionService->getUnresolvedIssues($version);
		var_dump($res);
	}
}

//change assignee
if (!function_exists('changeProjectAssignee')) {
	function changeProjectAssignee($issueKey,$accountId)
	{
		$issueService = new IssueService();
		$ret = $issueService->changeAssigneeByAccountId($issueKey, $accountId);
		echo "change assignee success";
	}
}

//get user info
if (!function_exists('getUserInfo')) {
	function getUserInfo($accountId)
	{
		$us = new UserService();
		$user = $us->get(['accountId' => $accountId]);
		var_dump($user);
	}
}

if (!function_exists('getUserInfo')) {
	function getUserInfo($accountId)
	{
		$us = new UserService();
		$user = $us->get(['accountId' => $accountId]);
		var_dump($user);
	}
}

//field
if (!function_exists('getAllFieldList')){
	function getAllFieldList(){
		$fieldService = new FieldService();
		// return custom field only.
		$ret = $fieldService->getAllFields(Field::CUSTOM);
		var_dump($ret);
	}
}

if (!function_exists('createField')){
	function createField(){
		$field = new Field();
		$field->setName('Độ ưu tiên')
			->setDescription('Mức độ ưu tiên của vấn đề')
			->setType('com.atlassian.jira.plugin.system.customfieldtypes:textarea')
			->setSearcherKey('com.atlassian.jira.plugin.system.customfieldtypes:textsearcher');
		$fieldService = new FieldService();
		$ret = $fieldService->create($field);
		var_dump($ret);
	}
}
// Link issue
if (!function_exists('linkIssue')){
	function linkIssue($issue1,$issue2,$linkType,$comment){
		$il = new IssueLink();

		$il->setInwardIssue($issue1)
			->setOutwardIssue($issue2)
			->setLinkTypeName($linkType)
			->setComment($comment);

		$ils = new IssueLinkService();

		$ret = $ils->addIssueLink($il);
		echo "link issue success!";
	}
}

