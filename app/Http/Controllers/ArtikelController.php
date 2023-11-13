<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Campusdigital\CampusCMS\Models\Tag;
use Campusdigital\CampusCMS\Models\Blog;
use Campusdigital\CampusCMS\Models\Komentar;
use Campusdigital\CampusCMS\Models\KategoriArtikel;

class ArtikelController extends Controller
{
    /**
     * Menampilkan artikel
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Referral
        referral($request->query('ref'), 'site.artikel.index');

        // Data artikel
        $artikel = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->orderBy('blog_at','desc')->paginate(12);

        // View
        return view('front.artikel.index', [
            'artikel' => $artikel,
        ]);
    }

    /**
     * Menampilkan detail artikel
     *
     * string $permalink
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, $permalink)
    {		
        // Referral
        referral($request->query('ref'), 'site.artikel.detail', ['permalink' => $permalink]);

        // Data artikel
        $artikel = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->where('blog_permalink','=',$permalink)->firstOrFail();

        // Tag artikel
        $artikel_tags = array();
        if($artikel->blog_tag != ''){
            $explode = explode(",", $artikel->blog_tag);
            foreach($explode as $id){
                $tag = Tag::find($id);
                if($tag) array_push($artikel_tags, $tag);
            }
        }

        // Komentar
        $artikel_komentar = Komentar::join('users','komentar.id_user','=','users.id_user')->where('id_artikel','=',$artikel->id_blog)->where('komentar_parent','=',0)->orderBy('komentar_at','desc')->get();

        // Tag
        $tag = Tag::limit(10)->get();

        // Artikel terbaru
        $recents = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->where('id_blog','!=',$artikel->id_blog)->orderBy('blog_at','desc')->limit(3)->get();

        // View
        return view('front.artikel.detail', [
            'artikel' => $artikel,
            'artikel_tags' => $artikel_tags,
            'artikel_komentar' => $artikel_komentar,
            'recents' => $recents,
            'tag' => $tag,
        ]);
    }

    /**
     * Menampilkan artikel berdasarkan kategori
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request, $category)
    {
        // Referral
        referral($request->query('ref'), 'site.artikel.category', ['category' => $category]);

        // Data kategori
        $kategori = KategoriArtikel::where('slug','=',$category)->firstOrFail();

        // Data artikel
        $artikel = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->where('blog_kategori','=',$kategori->id_ka)->orderBy('blog_at','desc')->paginate(12);

        // View
        return view('front.artikel.category', [
            'kategori' => $kategori,
            'artikel' => $artikel,
        ]);
    }

    /**
     * Menampilkan artikel berdasarkan tag
     *
     * string $tag
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function tag(Request $request, $tag)
    {
        // Referral
        referral($request->query('ref'), 'site.artikel.tag', ['tag' => $tag]);

        // Data tag
        $tag = Tag::where('slug','=',$tag)->firstOrFail();

        // Data artikel
        $blogs = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->orderBy('blog_at','desc')->get();

        // Tag filter
        $ids = array();
        foreach($blogs as $key=>$blog){
            if($blog->blog_tag != ''){
                $explode = explode(',', $blog->blog_tag);
                if(in_array($tag->id_tag, $explode)){
                    array_push($ids, $blog->id_blog);
                }
            }
        }

        // Data artikel setelah di filter
        $artikel = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->whereIn('id_blog',$ids)->orderBy('blog_at','desc')->paginate(12);

        // View
        return view('front.artikel.tag', [
            'artikel' => $artikel,
            'tag' => $tag,
        ]);
    }
}
