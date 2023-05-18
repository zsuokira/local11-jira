<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Field\Field;
use JiraRestApi\Field\FieldService;
use JiraRestApi\JiraException;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\Issue\Worklog;

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

