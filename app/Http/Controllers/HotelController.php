<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Hotel\ViewModels\HotelViewModel;
use Domain\Review\ViewModels\ReviewViewModel;
use Illuminate\Contracts\View\View;

class HotelController extends Controller
{
    public function show(string $slug, HotelViewModel $hotels, ReviewViewModel $reviews): View
    {
        $hotel = $hotels->oneHotel($slug);

        abort_if(!$hotel, 404);

        return view('pages.hotels.show', [
            'hotel' => $hotel,
            'reviews' => $reviews->reviewsOfHotel($hotel->id),
        ]);
    }
}
