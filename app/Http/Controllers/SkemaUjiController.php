<?php

namespace App\Http\Controllers;

use App\Models\SkemaUji;
use App\Models\SkemaUk;
use Illuminate\Http\Request;

class SkemaUjiController extends Controller
{
    public function index()
    {
        $skemaUjis = SkemaUji::with('skema_uks')->latest()->get();
        return view('admin.skema-uji.index', compact('skemaUjis'));
    }

    public function create()
    {
        return view('admin.skema-uji.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_skema' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'kode_uk' => 'nullable|array',
            'judul_uk' => 'nullable|array',
        ]);

        $skemaUji = SkemaUji::create([
            'nama_skema' => $request->nama_skema,
            'status' => $request->status,
        ]);

        // Simpan Unit Kompetensi (jika ada input dinamis)
        if ($request->has('kode_uk') && $request->has('judul_uk')) {
            foreach ($request->kode_uk as $key => $kode) {
                if (!empty($kode) && !empty($request->judul_uk[$key])) {
                    SkemaUk::create([
                        'skema_uji_id' => $skemaUji->id,
                        'kode' => $kode,
                        'judul' => $request->judul_uk[$key],
                    ]);
                }
            }
        }

        return redirect()->route('admin.skema-uji.index')->with('success', 'Data Skema Uji berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $skemaUji = SkemaUji::with('skema_uks')->findOrFail($id);
        return view('admin.skema-uji.edit', compact('skemaUji'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_skema' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'kode_uk' => 'nullable|array',
            'judul_uk' => 'nullable|array',
        ]);

        $skemaUji = SkemaUji::findOrFail($id);
        $skemaUji->update([
            'nama_skema' => $request->nama_skema,
            'status' => $request->status,
        ]);

        // Hapus UK lama, insert UK baru (untuk mempermudah update dinamis)
        $skemaUji->skema_uks()->delete();

        if ($request->has('kode_uk') && $request->has('judul_uk')) {
            foreach ($request->kode_uk as $key => $kode) {
                if (!empty($kode) && !empty($request->judul_uk[$key])) {
                    SkemaUk::create([
                        'skema_uji_id' => $skemaUji->id,
                        'kode' => $kode,
                        'judul' => $request->judul_uk[$key],
                    ]);
                }
            }
        }

        return redirect()->route('admin.skema-uji.index')->with('success', 'Data Skema Uji berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $skemaUji = SkemaUji::findOrFail($id);
        $skemaUji->delete(); // Otomatis menghapus data di skema_uks karena constraint on delete cascade

        return redirect()->route('admin.skema-uji.index')->with('success', 'Data Skema Uji berhasil dihapus.');
    }
}