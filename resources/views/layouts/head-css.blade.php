@yield('css')
<!-- Layout config Js -->
<script src="{{ URL::asset('build/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ URL::asset('build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="{{ URL::asset('build/css/custom.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

<script>
      .w-10 {
        width: 10% !important;
    },
    .w-20 {
        width: 15% !important;
    },
    .w-30 {
        width: 30% !important;
    },
    .w-40 {
        width: 40% !important;
    },
    .w-50 {
        width: 50% !important;
    }
     
    .form-control {
        max-width: 100%;
    }

    .chocolat-image {
        max-height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }

    .img-fluid {
        width: auto;
        max-width: 100%;
        height: auto;
    }

    /* Responsif: Menyusun elemen gambar dan nama file dalam satu baris */
    .d-flex {
        display: flex;
        align-items: center;
    }

    .ms-3 {
        margin-left: 1rem;
    }

    /* Jika ukuran gambar melebihi 400px, sesuaikan agar lebih responsif */
    .img-fluid.chocolat-image {
        width: 100%;
        max-width: 200px;
    }

    /* Pastikan tampilan mobile-friendly */
    @media (max-width: 576px) {
        .chocolat-image {
            max-width: 120px;
            max-height: 120px;
        }
    }
</script>