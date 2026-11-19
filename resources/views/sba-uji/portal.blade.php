<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Asesmen (SBA)</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .bg-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        .portal-card {
            z-index: 2;
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .portal-header {
            background: linear-gradient(135deg, #6f42c1 0%, #512da8 100%);
            padding: 25px 20px;
            text-align: center;
            color: white;
        }
        .input-group-text {
            background-color: #f8f9fc;
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
            border-radius: 0.375rem;
        }
        .btn-primary-custom {
            background-color: #6f42c1;
            border-color: #6f42c1;
            font-weight: bold;
            padding: 12px;
        }
        .btn-primary-custom:hover {
            background-color: #59359a;
            border-color: #59359a;
        }
        .kode-input {
            letter-spacing: 5px; 
            font-size: 1.5rem; 
            font-weight: bold;
            text-align: center;
            border: 2px solid #6f42c1;
            padding: 15px;
        }
    </style>
</head>
<body>

    <div class="bg-overlay"></div>

    <div class="container position-relative z-2 d-flex justify-content-center px-3">
        <div class="portal-card border-0">
            
            <div class="portal-header">
                <h4 class="fw-bold mb-1">PORTAL ASESMEN</h4>
                <p class="mb-0 text-white-50">Smart Based Assessment (SBA)</p>
            </div>

            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger text-center py-2 shadow-sm text-sm" role="alert">
                        <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning text-center py-2 shadow-sm text-sm" role="alert">
                        <i class="fas fa-info-circle me-1"></i> {{ session('warning') }}
                    </div>
                @endif

                <form action="{{ route('sba.portal.process') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label id="labelIdentitas" class="form-label fw-bold text-dark small mb-1">Nama Lengkap</label>
                        <div class="input-group shadow-sm mb-2">
                            <span class="input-group-text text-secondary border-secondary-subtle">
                                <i id="iconIdentitas" class="fas fa-user"></i>
                            </span>
                            <input type="text" id="inputIdentitas" name="nama_lengkap" class="form-control border-secondary-subtle" value="{{ old('nama_lengkap') }}" placeholder="Masukkan Nama Lengkap Anda" required>
                        </div>
                    </div>

                    <!-- INPUT KODE UJIAN (Otomatis terisi jika diakses melalui quicklink ?kode=...) -->
                    <div class="mb-4 text-center">
                        <label class="form-label fw-bold text-dark small mb-2">Kode Asesmen</label>
                        <input type="text" name="kode_uji" class="form-control kode-input text-uppercase shadow-sm" value="{{ old('kode_uji', request('kode')) }}" placeholder="KODE" required>
                    </div>

                    <button type="submit" class="btn btn-primary-custom text-white w-100 shadow-sm rounded-3 mb-2">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk Ruang Ujian
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>