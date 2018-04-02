<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\PageViewRanking;

class GetRecentlyReviewRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yyux:getRecentlyReviewRanking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get recentl pageviews ranking of review';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::transaction(function () {
            DB::table('page_view_ranking')->truncate();
            $analytics = $this->initializeAnalytics();
            $profile = $this->getFirstProfileId($analytics);
            $results = $this->getResults($analytics, $profile);
            foreach ($results as $key => $result) {
                $ranking = new PageViewRanking;
                $ranking->review_id = str_replace("/post/", "", $result[0]);
                $ranking->page_views = $result[2];
                $ranking->save();
            }
        });
    }

    private function initializeAnalytics() {
        $client = new \Google_Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig(\Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'yyUX-5e006710603d.json');
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
            "dimensions" => 'ga:pagePath, ga:pageTitle', //ディメンション：区切り 日付ごとに
            "filters" => "ga:pagePath=~^/post/[0-9]+$",
            'sort'        => '-ga:pageviews',
            'max-results' => '20',
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
