<?php namespace App\Http\Controllers;

use App\Location;
use App\QuestionCategory;
use App\BaseUser;
use App\ReviewComment;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class LocationReportController extends Controller {

    public function show2(string $location_id, $question_category_id)
	{
		$location = Location::find($location_id);
		$question_categories = QuestionCategory::with('questions')->get();
		$question_category_id = intval($question_category_id);
		$question_category = QuestionCategory::find($question_category_id);
		$view_data = [
			'location' => $location,
			'question_categories' => $question_categories,
			'question_category' => $question_category
		];
		return view('pages.location_report.question_category_report', $view_data);
	}

    public function show(string $location_id, $rating_system = null)
    {
		if ($rating_system !== 'personal') {
			$rating_system = 'universal';
		}
		$location = Location::find($location_id);
		$question_categories = QuestionCategory::with('questions')->get();
		$view_data = [
			'location' => $location,
			'question_categories' => $question_categories,
			'google_map_api_key' => config('app.google_map_api_key'),
			'rating_system' => $rating_system,
			'personal_rating_is_available' => BaseUser::isCompleteAccessibilityProfile(),
			'turn_off_maps' => config('app.turn_off_maps'),
			'num_ratings' => 0
		];
		
		return view('pages.location_report.collapsed', $view_data);
    }

}