<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logos;
use Response;
use App\Http\Resources\Logos as LogosResource;

class LogoController extends Controller
{
    //
    public function index()
    {
        //Get all users
        $logos = Logos::get();

        // Return a collection of $users with pagination
        return LogosResource::collection($logos);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $skill
     * @return Response
     * curl --user admin:admin localhost/project/api/v1/pages/2
     */

    public function getLogos($skill) {
        $skill = str_replace(' ', '', $skill);
        $logos = Logos::where('skill', $skill)
            ->take(1)
            ->pluck('logo');
        return $logos;
    }
}
