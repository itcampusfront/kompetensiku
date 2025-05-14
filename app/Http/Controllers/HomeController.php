<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Campusdigital\CampusCMS\Models\Blog;
use Campusdigital\CampusCMS\Models\Mitra;
use Illuminate\Support\Facades\Validator;
use Campusdigital\CampusCMS\Models\Slider;
use Campusdigital\CampusCMS\Models\Gallery;
use Campusdigital\CampusCMS\Models\Program;

class HomeController extends Controller
{		
    /**
     * Home Page
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Referral
        // referral($request->query('ref'), 'site.home');

        // Data slider
        $slider = Slider::where('status_slider','=',1)->orderBy('order_slider','asc')->get();

        // Data program
        $program = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->orderBy('program_at', 'desc')->limit(12)->get();

        // Data mitra
        $mitra = Mitra::orderBy('order_mitra','asc')->get();

        // Data artikel terbaru
        $artikel = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->orderBy('blog_at','desc')->limit(3)->get();

        $gallery = Gallery::orderBy('id','desc')->limit(3)->get();
        // View
        return view('front.home', [
            'artikel' => $artikel,
            'g' => $gallery,
            'mitra' => $mitra,
            'program' => $program,
            'slider' => $slider,
		]);
    }

    /**
     * Search Page
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Keyword dan kategori
        $validator = Validator::make($request->query(), [
            'q' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $q = $request->query('q');

        // Data artikel
        $artikel = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->where('blog_title','like','%'.$q.'%')->orderBy('blog_at','desc')->paginate(12);
        
        // Data program
        $program = Program::join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->where('program_title','like','%'.$q.'%')->orderBy('program_at','desc')->paginate(12);

        // View
        return view('front.search', [
            'artikel' => $artikel,
            'program' => $program,
        ]);
    }
}
