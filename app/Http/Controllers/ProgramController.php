<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Campusdigital\CampusCMS\Models\Program;
use Campusdigital\CampusCMS\Models\Pelatihan;

class ProgramController extends Controller
{
    /**
     * Menampilkan program
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Referral
        referral($request->query('ref'), 'site.program.index');

        // Data program
        $program_bnsp = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->where('kategori_program.slug','=','bnsp')->orderBy('program_at', 'desc')->get();
        $program_nonbnsp = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->where('kategori_program.slug','=','non-bnsp')->orderBy('program_at', 'desc')->get();
        $program_prakerja = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->where('kategori_program.slug','=','program-prakerja')->orderBy('program_at', 'desc')->get();

        // View
        return view('front.program.index', [
            'program_bnsp' => $program_bnsp,
            'program_nonbnsp' => $program_nonbnsp,
            'program_prakerja' => $program_prakerja,
        ]);
    }

    /**
     * Menampilkan detail program
     *
     * string $permalink
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, $permalink)
    {		
        // Referral
        referral($request->query('ref'), 'site.program.detail', ['permalink' => $permalink]);

        // Data program
        $program = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->where('program_permalink','=',$permalink)->firstOrFail();

        // Program lainnya
        $program_lainnya = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->orderBy('program_at', 'desc')->limit(5)->get();
        $pelatihan = Pelatihan::where('id_program', '=', $program->id_program)->where('status',1)->get();
        // dd(count($pelatihan));
        // View
        return view('front.program.detail', [
            'program' => $program,
            'program_lainnya' => $program_lainnya,
            'pelatihan' => $pelatihan
        ]);
    }
}
