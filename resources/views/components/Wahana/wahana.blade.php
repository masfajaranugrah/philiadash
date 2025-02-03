
@extends('layouts.master')
@section('title') @lang('translation.datatables') @endsection
@section('css')
<style>
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
</style>
</style>
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Tables @endslot
@slot('title')Fasilitas @endslot
@endcomponent
 
@if(session('success'))
<pre>{{ var_dump(session()->all()) }}</pre>
@endif
 

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button class="btn  btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#showModal">Add Fasilitas</button>
            </div>
            <button type="button" data-toast
                                            data-toast-text="Welcome Back ! This is a Toast Notification"
                                            data-toast-gravity="bottom" data-toast-position="right"
                                            data-toast-duration="3000" data-toast-close="close"
                                            class="btn btn-light w-xs">Bottom Right</button>
                             
               
            <div class="card-body">
                <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Images</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $wahana as $items )
                        <tr>
                            <td class="w-20 text-wrap">{{ $items->title }}</td>
                            
                            <td class="w-20 text-wrap">{{ $items->description }}</td>
                             
                            <td class="w-20 text-wrap">{{ $items->location }}</td>
                            <td class="w-20 text-wrap">{{ 'Rp ' . number_format($items->price, 0, ',', '.') }}</td>
                            
                            <td>
                                <img src="{{ asset('storage/wahana/' . $items->images) }}" alt="{{$items->images}}" class="img-fluid chocolat-image" width="100">
                            </td>
                   
                            <td>
                                <div class="d-flex gap-2">
                                    <div class="edit">
                                        <button class="btn btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#EditModal-{{ $items->id_wahana }}">Edit</button>
                                    </div>
                                    <div class="remove">
                                        <form id="delete-form-{{ $items->id_wahana }}" action="{{ route('delete', $items->id_wahana) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $items->id_wahana }}')">Delete</button>
                                        </form>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                 @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->


 

  {{-- add  --}}
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Add Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" action="{{route('create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="mb-3" >
                        <label for="id-field" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="title" id="validationTooltip01" placeholder="Masukkan Judul"  required>
                    </div>

                    <div class="mb-3">
                        <label for="customername-field" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" name="description" id="validationTooltip02"  placeholder="Masukkan Deskripsi"   required>
                     
                    </div>

                    <div class="mb-3">
                        <label for="email-field" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" name="location" id="validationTooltip02"  placeholder="Masukkan Lokasi"    required>
                    </div>

                    <div class="mb-3">
                        <label for="price-field" class="form-label">Harga</label>
                        <input type="text" class="form-control" id="price-input" required placeholder="Rp. 1.000.000">
                        <input type="hidden" name="price" id="price-hidden">
                    </div>

                    {{-- <div class="mb-3">
                        <label for="date-field" class="form-label">Gambar</label>
                        <input type="file" id="date-field" class="form-control" name="images" placeholder="Select Date" required >
                    </div> --}}

                    <div class="mb-3">
                        <label for="date-field" class="form-label">Gambar</label>
                        <input type="file" id="date-field" class="form-control" name="images" placeholder="Select Date" required onchange="previewImage(event)">
                    </div>
                    
                    <!-- Tempat untuk menampilkan preview gambar -->
                    <div class="mb-3" id="image-preview-container" style="display:none;">
                        <label class="form-label">Preview Gambar:</label>
                        <img id="image-preview" src="" alt="Preview Gambar" class="img-fluid" style="max-width: 300px;">
                    </div>
                </div>

 
            



                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Add Fasilitas</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 
{{-- edit   --}}
@foreach ($wahana as $items )
  <div class="modal fade" id="EditModal-{{ $items->id_wahana }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Edit Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" action="{{ route('update', $items->id_wahana) }}" method="post" enctype="multipart/form-data">
                 @method('PATCH')
                    @csrf
                <div class="modal-body">
                  
                    <div class="mb-3" >
                        <label for="id-field" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $items->title }}" id="validationTooltip01"  required>
                    </div>

                    <div class="mb-3">
                        <label for="customername-field" class="form-label">Description</label>
                        <input type="text" class="form-control" name="description" value="{{ $items->description }}" id="validationTooltip02" required>
                    </div>

                    <div class="mb-3">
                        <label for="email-field" class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" value="{{ $items->location }}" id="validationTooltip02"   required>
                    </div>

                    <div class="mb-3">
                        <label for="email-field" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price-input-edit" 
                        value="Rp {{ number_format($items->price, 0, ',', '.') }}" 
                        required placeholder="Rp 1.000.000">
                 <input type="hidden" name="price" id="price-hidden-edit" value="{{ $items->price }}">
                     </div>
                   



                     <div class="mb-3">
                        <label for="date-field" class="form-label">Images</label>
                        <input type="file" id="date-field" class="form-control" name="images">
                    
                        @if ($items->images)
                            <div class="mt-3">
                                <strong>Gambar Sebelumnya:</strong>
                                <div class="d-flex align-items-center mt-2">
                                    <img src="{{ asset('storage/wahana/' . $items->images) }}" alt="{{ $items->images }}" class="img-fluid chocolat-image" width="100">
                                    <span class="ms-3">{{ $items->images }}</span> <!-- Menampilkan nama file gambar -->
                                </div>
                            </div>
                        @endif
                    </div>       
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn " >Edit Fasilitas</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>  
@endforeach

 

 
<!--end row-->
@endsection
@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!--datatable js-->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/notifications.init.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
  <script>
    document.getElementById("price-input").addEventListener("input", function () {
        let value = this.value.replace(/[^0-9]/g, ""); // Hanya angka
        if (value) {
            this.value = formatRupiah(value);
            document.getElementById("price-hidden").value = value; // Kirim data angka asli ke hidden input
        }
    });
    
    function formatRupiah(angka) {
        return "Rp " + angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
 
    </script>  
 <script>
    document.addEventListener("DOMContentLoaded", function () {
        let priceInput = document.getElementById("price-input-edit");
        let priceHidden = document.getElementById("price-hidden-edit");

        // Format awal dari database
        if (priceHidden.value) {
            priceInput.value = formatRupiah(priceHidden.value);
        }

        // Event listener saat input berubah
        priceInput.addEventListener("input", function () {
            let value = this.value.replace(/[^0-9]/g, ""); // Hanya angka
            if (value) {
                this.value = formatRupiah(value);
                priceHidden.value = value; // Simpan angka asli di input hidden
            } else {
                priceHidden.value = ""; // Kosongkan input hidden jika tidak ada angka
            }
        });

        // Event listener saat input kehilangan fokus
        priceInput.addEventListener("blur", function () {
            let value = this.value.replace(/[^0-9]/g, "");
            if (value) {
                this.value = formatRupiah(value);
            }
        });
    });

    function formatRupiah(angka) {
        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
<script>
    function previewImage(event) {
        const file = event.target.files[0]; // Ambil file pertama yang dipilih
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Set source gambar preview dengan file yang dipilih
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block'; // Tampilkan preview gambar
            };
            reader.readAsDataURL(file); // Membaca file sebagai URL data
        } else {
            previewContainer.style.display = 'none'; // Sembunyikan preview jika tidak ada gambar
        }
    }
</script>
 <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
