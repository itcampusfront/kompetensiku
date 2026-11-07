<?php

namespace App\Http\Controllers;

use App\Models\SkemaJadwal;
use App\Models\SkemaUji;
use Illuminate\Http\Request;

class SkemaJadwalController extends Controller
{
    public function index()
    {
        $jadwals = SkemaJadwal::with('skema_uji')->latest()->get();
        return view('admin.skema-jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        // Hanya mengambil Skema Uji yang aktif untuk pilihan pembuatan jadwal
        $skemaUjis = SkemaUji::where('status', 'Aktif')->get();
        return view('admin.skema-jadwal.create', compact('skemaUjis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skema_uji_id' => 'required|exists:skema_ujis,id',
            'nama_jadwal'  => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tgl_mulai'    => 'required|date',
            'tgl_selesai'  => 'required|date|after_or_equal:tgl_mulai',
            'status'       => 'required|in:Buka,Tutup',
        ]);

        SkemaJadwal::create($request->all());

        return redirect()->route('admin.skema-jadwal.index')->with('success', 'Jadwal Uji berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = SkemaJadwal::findOrFail($id);
        $skemaUjis = SkemaUji::where('status', 'Aktif')->orWhere('id', $jadwal->skema_uji_id)->get();
        return view('admin.skema-jadwal.edit', compact('jadwal', 'skemaUjis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'skema_uji_id' => 'required|exists:skema_ujis,id',
            'nama_jadwal'  => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tgl_mulai'    => 'required|date',
            'tgl_selesai'  => 'required|date|after_or_equal:tgl_mulai',
            'status'       => 'required|in:Buka,Tutup',
        ]);

        $jadwal = SkemaJadwal::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('admin.skema-jadwal.index')->with('success', 'Jadwal Uji berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = SkemaJadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.skema-jadwal.index')->with('success', 'Jadwal Uji berhasil dihapus.');
    }
}