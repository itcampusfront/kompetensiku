@extends('faturcms::template.admin.main')

@section('title', 'Tambah Program')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Program',
        'items' => [
            ['text' => 'Program', 'url' => route('admin.program.index')],
            ['text' => 'Tambah Program', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <form id="form" method="post" action="{{ route('admin.program.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Judul Program <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="judul_program" class="form-control {{ $errors->has('judul_program') ? 'is-invalid' : '' }}" value="{{ old('judul_program') }}">
                                @if($errors->has('judul_program'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('judul_program')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}" >
                                    <option value="" disabled selected>--Pilih--</option>
                                    @foreach($kategori as $data)
                                    <option value="{{ $data->id_kp }}" {{ old('kategori') === $data->id_kp ? 'selected' : '' }}>{{ $data->kategori }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('kategori'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('kategori')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar Promo/program</label>
                            <div class="col-md-10">
                                <input type="file" id="program_gambar" name="program_gambar" accept="image/*">
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar Sertifikat</label>
                            <div class="col-md-10">
                                <input type="file" id="file" class="d-none" accept="image/*">
                                <a class="btn btn-sm btn-secondary btn-image" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img id="img-file" class="mt-2 img-thumbnail d-none" style="max-height: 150px">
                                <input type="hidden" name="gambar">
                                <input type="hidden" name="gambar_url">
                            </div>
                        </div>
                         --}}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Deskripsi Pelatihan</label>
                            <div class="col-md-10">
                                <textarea name="konten" class="form-control"></textarea>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-md-2 col-form-label">Materi Pelatihan <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="program_materi" class="form-control" placeholder="Gunakan tanda koma sebagai pemisah jika lebih dari 1.....">
                                @if($errors->has('program_materi'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('program_materi')) }}</div>
                                @endif
                            </div>
                        </div> --}}
                        {{-- <div class="form-group row">
                            <label class="col-md-2 col-form-label">Penjelasan Per poin materi</label>
                            <div class="col-md-10">
                                <textarea name="materi_desk" class="form-control" placeholder="Gunakan tanda koma sebagai pemisah, wajib diurutkan berdasarkan poin materi di kolom atasnya"></textarea>
                                @if($errors->has('materi_desk'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('materi_desk')) }}</div>
                                @endif
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Materi</label>
                            <div class="col-md-10">
                                <table class="table table-sm table-bordered" id="table-dr">
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Price Pelatihan<span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <table class="table-sm table-bordered">
                                    <tbody>
                                        <tr>
                                            <td width="500"><input type="number" name="price[0]" class="form-control" placeholder="Harga Pelatihan"></td>
                                            <td width="500"><input type="number" name="price[1]" class="form-control" placeholder="Harga Diskon"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Manfaat Pelatihan</label>
                            <div class="col-md-10">
                                <textarea name="program_manfaat" class="d-none"></textarea>
                                <div id="editor"></div> 
                                @if($errors->has('program_manfaat'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('program_manfaat')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-theme-1"><i class="fa fa-save mr-2"></i>Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@include('faturcms::template.admin._modal-image', ['noCroppie' => true, 'croppieWidth' => 640, 'croppieHeight' => 360])

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-image', ['imageType' => 'program', 'noCroppie' => true, 'croppieWidth' => 640, 'croppieHeight' => 360])

@include('faturcms::template.admin._js-editor')

<script type="text/javascript">
    // Quill
    generate_quill("#editor");

    // Button Submit
    $(document).on("click", "button[type=submit]", function(e){
        var myEditor = document.querySelector('#editor');
        var html = myEditor.children[0].innerHTML;
        $("textarea[name=program_manfaat]").text(html);
        $("#form").submit();
    });

    $(window).on("load", function(){
        //table input for PENJELASAN
        var tlength = $("#table-dr tbody tr").length;
        if(tlength == 0) $("#table-dr tbody").append(make_html());
    })

    $(document).on("click", ".btn-add-row", function(e){
        e.preventDefault();
        var id = $(this).parents(".table").attr("id");
        if(id == "table-dr") $(this).parents(".table").find("tbody").append(make_html());
        recreate();
    })

    $(document).on("click",".btn-delete-row", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var length = $(this).parents(".table").find("tbody tr").length;
        if(length > 1) cekid = $(this).parents(".table").find("tbody tr[data-id="+id+"]").remove();
           
    })

    //html
    function make_html(){
        var html ='';
        html += '<tr data-id="0">';
        html += '<td width="200"><input type="text" name="program_materi[]" placeholder="Judul Materi" class="form-control form-control-sm"></td>';
        html += '<td>';
        html += '<textarea placeholder="Penjelasan Singkat Materi" name="materi_desk[]" class="form-control form-control-sm" rows="2"></textarea>';
        html += '</td>';
        html += '<td width="80" align="center">';
        html += '<input type="hidden" name="materih_id[]">';
        html += '<div class="btn-group">';
        html += '<a href="#" class="btn btn-success btn-sm btn-add-row" data-id="0" data-bs-toggle="tooltip" title="Tambah"><i class="fa fa-plus"></i></a>';
        html += '<a href="#" class="btn btn-danger btn-sm btn-delete-row" data-id="0" data-bs-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>';
        html += '</div>';
        html += '</td>';
        html += '</tr>';
        return html;
    }

    function make_html_next(){
        var html ='';
        html += '<tr data-id="0">';
        html += '<td>';
        html += '<textarea name="materi_desk[]" class="form-control form-control-sm" rows="2"></textarea>';
        html += '</td>';
        html += '<td width="80" align="center">';
        html += '<input type="hidden" name="materih2_id[]">';
        html += '<div class="btn-group">';
        html += '<a href="#" class="btn btn-success btn-sm btn-add-row" data-id="0" data-bs-toggle="tooltip" title="Tambah"><i class="fa fa-plus"></i></a>';
        html += '<a href="#" class="btn btn-danger btn-sm btn-delete-row" data-id="0" data-bs-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>';
        html += '</div>';
        html += '</td>';
        html += '</tr>';
        return html;
    }

    function recreate(){
        $(".table tbody tr").each(function(key,element){
            $(element).attr("data-id",key);
            $(element).find(".btn-add-row").attr("data-id", key);
            $(element).find(".btn-delete-row").attr("data-id", key);
        });
    }
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">

@endsection