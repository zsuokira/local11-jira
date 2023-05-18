<?php
require 'vendor/autoload.php';
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\IssueService;
class MyService extends CI_Service {

	public function __construct(ArrayConfiguration $config) {
		parent::__construct();
		$this->config = $config;
		$iss = new IssueService(new ArrayConfiguration(
			[
				'jiraHost' => 'https://local11-jira.atlassian.net/',
				'useTokenBasedAuth' => true,
				'personalAccessToken' => 'ATATT3xFfGF0JClTc--4zWbJwZRql400u86KwO7FUOD4-3LLSezQcKsAEv8DBeOq8qYiJ25MB49Ofot0u9UTeKTuoWGLbtopf7cNzhgu-iWWjQEayfjURT24b4gzZsnT6kkcUlVpkciqvcwWVJBlDg9pReK1IqUV4G6u1vIOe0NEnQRKAoL5Riw=DC772E29',
			]
		));
	}



}
