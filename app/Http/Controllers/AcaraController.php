<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Campusdigital\CampusCMS\Models\Acara;

class AcaraController extends Controller
{
    /**
     * Menampilkan acara
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Referral
        referral($request->query('ref'), 'site.acara.index');

        // Data acara
        $acara = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->orderBy('tanggal_acara_from','desc')->paginate(12);

        // View
        return view('front.acara.index', [
            'acara' => $acara,
        ]);
    }

    /**
     * Menampilkan detail acara
     *
     * string $permalink
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, $permalink)
    {		
        // Referral
        referral($request->query('ref'), 'site.acara.detail', ['permalink' => $permalink]);

        // Data acara
        $acara = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->where('id_acara','=',$permalink)->firstOrFail();

        // Acara lainnya
        $acara_lainnya = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->where('id_acara','!=',$permalink)->orderBy('tanggal_acara_from','desc')->limit(5)->get();

        // View
        return view('front.acara.detail', [
            'acara' => $acara,
            'acara_lainnya' => $acara_lainnya,
        ]);
    }
}
