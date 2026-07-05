<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Review\ViewModels\ReviewViewModel;
use Illuminate\Contracts\View\View;

class ReviewController extends Controller
{
    public function index(ReviewViewModel $reviews): View
    {
        return view('pages.reviews.index', [
            'reviews' => $reviews->listReviews(),
        ]);
    }
}
