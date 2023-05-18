<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Field\Field;
use JiraRestApi\Field\FieldService;
use JiraRestApi\JiraException;
use JiraRestApi\Issue\IssueField;


if ( ! function_exists('getIssue'))
{
	function getIssue($issueKey)
	{
		$issueService = new IssueService();
		$issue = $issueService->get($issueKey);

		return $issue->fields->summary;
	}
}

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

if (!function_exists('addAttachments')) {
	function addAttachments($issueKey, $att)
	{
		$issueService = new IssueService();
		$ret = $issueService->addAttachments($issueKey, $att);
		print_r($ret);
	}
}

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
