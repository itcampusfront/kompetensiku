<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Campusdigital\CampusCMS\Models\Mentor;

class MentorController extends Controller
{
    /**
     * Menampilkan mentor
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Referral
        // referral($request->query('ref'), 'site.mentor.index');

        $mentor = Mentor::orderBy('order_mentor', 'asc')->get();

        // View
        return view('front.mentor.index', [
            'mentor' => $mentor,
        ]);
    }

}
