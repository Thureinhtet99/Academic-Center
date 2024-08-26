<?php

namespace App\Http\Controllers\Api;

use App\Models\Carousel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarouselApiController extends Controller
{
    // Index
    public function index()
    {
        return Carousel::select("id", "carousel_image", "carousel_description")->get();
    }
}
