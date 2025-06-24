<div class="col-12 custom-col-430 col-sm-6 col-md-4 col-lg-3 mb-3 d-flex align-items-stretch p-0">
    <div class="card p-1 border-0 shadow-sm rounded-1 w-100">
        <a href="{{ route('site.artikel.detail', ['permalink' => $data->blog_permalink]) }}">
            <img class="card-img-top rounded-1" style="height: 200px; width: 100%; object-fit: cover;"
                src="{{ image('assets/images/blog/' . $data->blog_gambar, 'blog') }}" alt="thumbnail">
        </a>
        <div class="card-body">
            <a class="text-decoration-none text-body"
                href="{{ route('site.artikel.detail', ['permalink' => $data->blog_permalink]) }}">
                <span>{{ $data->blog_title }}</span>
            </a>
        </div>
        <div class="card-footer bg-transparent mx-3 px-0 text-muted d-flex justify-content-between align-items-center">
            <span><i class="fa fa-calendar"></i> {{ date('d/m/Y', strtotime($data->blog_at)) }}</span>
            <span><i class="fa fa-comments"></i> {{ count_komentar($data->id_blog) }}</span>
        </div>
    </div>
</div>
