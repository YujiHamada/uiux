<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller {

	// Analyticsから値を取得する時はこのメソッドを呼び出す。下記リンクを参考に作成
	// https://developers.google.com/analytics/devguides/reporting/core/v3/quickstart/service-php?hl=ja
	public function analytics() {
		$analytics = $this->initializeAnalytics();
		$profile = $this->getFirstProfileId($analytics);
		$results = $this->getResults($analytics, $profile);
		echo "<pre>";print_r($results->rows);echo "</pre>";
		exit;
	}

	private function initializeAnalytics() {
		$client = new \Google_Client();
		$client->setApplicationName("Hello Analytics Reporting");
		$client->setAuthConfig('yyUX-5e006710603d.json');
		$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
		$analytics = new \Google_Service_Analytics($client);

		return $analytics;
	}

	function getFirstProfileId($analytics) {
		$accounts = $analytics->management_accounts->listManagementAccounts();
		if (count($accounts->getItems()) > 0) {
			$items = $accounts->getItems();
			$firstAccountId = $items[0]->getId();

            // Get the list of properties for the authorized user.
			$properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);

			if (count($properties->getItems()) > 0) {
				$items = $properties->getItems();
				$firstPropertyId = $items[0]->getId();

                // Get the list of views (profiles) for the authorized user.
				$profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstPropertyId);

				if (count($profiles->getItems()) > 0) {
					$items = $profiles->getItems();

                    // Return the first view (profile) ID.
					return $items[0]->getId();

				} else {
					throw new Exception('No views (profiles) found for this user.');
				}
			} else {
				throw new Exception('No properties found for this user.');
			}
		} else {
			throw new Exception('No accounts found for this user.');
		}
	}

	function getResults($analytics, $profileId) {
      // Calls the Core Reporting API and queries for the number of sessions
      // for the last seven days.
		$metrics = "ga:pageviews";

		$option = [
            "dimensions" => 'ga:pageTitle, ga:pagePath', //ディメンション：区切り 日付ごとに
            "filters" => "ga:pagePath=~^/post/[0-9]+$",
        ];

        return $analytics->data_ga->get(
        	'ga:' . $profileId,
        	'2017-12-28',
        	'today',
        	$metrics,
        	$option);
    }

    function printResults($results) {
      // Parses the response from the Core Reporting API and prints
      // the profile name and total sessions.
    	if (count($results->getRows()) > 0) {

            // Get the profile name.
    		$profileName = $results->getProfileInfo()->getProfileName();

            // Get the entry for the first entry in the first row.
    		$rows = $results->getRows();
    		$sessions = $rows[0][0];

            // Print the results.
    		print "First view (profile) found: $profileName\n";
    		print "Total sessions: $sessions\n";
    	} else {
    		print "No results found.\n";
    	}
    }
}
