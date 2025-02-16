
@extends('layouts.master')
@section('title') Wahana @endsection

@section('css')
 
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .modal-content {
    position: relative;
    display: flex
;
    flex-direction: column;
    width: 100%;
    height: 100% !important;
    color: var(--tb-modal-color);
    pointer-events: auto;
    background-color: var(--tb-modal-bg);
    background-clip: padding-box;
    border: var(--tb-modal-border-width) solid var(--tb-modal-border-color);
    border-radius: var(--tb-modal-border-radius);
    outline: 0;
}
</style>
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Tables @endslot
@slot('title')Kegiatan @endslot
@endcomponent
 
 <div class="alert alert-success" role="alert">
   Ukuran gambar yang direkomendasikan adalah <b>370x210 px </b>
            </div>    
<div class="row">
     
    <div class="col-lg-12">
        <div class="card"> 
            <div class="card-header">
                <button class="btn  btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#showModal">Add Kegiatan</button>
            </div>
        
                      
               
            <div class="card-body">
                <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Images</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $whats as $items )
                        <tr>

                            <td>
                                <img src="{{ asset('storage/whats/' . $items->images) }}" alt="{{$items->images}}" class="img-fluid chocolat-image" width="100">

                            </td>
                            
                            <td>
                                <div class="d-flex gap-2">
                                    <div class="edit">
                                        <button class="btn btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#EditModal-{{ $items->id_whats }}">Edit</button>
                                    </div>
                                    <div class="remove">
                                        <form id="delete-form-{{ $items->id_whats }}" action="{{ route('whats.delete', $items->id_whats) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $items->id_whats }}')">Delete</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" action="{{route('whats.create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body ">
 
               
  

                    <div class="mb-3">
                        <label for="date-field" class="form-label">Gambar</label>
                        <input type="file" id="date-field" class="form-control" name="images" placeholder="Select Date" required onchange="previewImage(event)">
                    </div>
                    
                    <!-- Tempat untuk menampilkan preview gambar -->
                    <div class="mb-3" id="image-preview-container" style="display:none;">
                        <label class="form-label">Preview Gambar:</label>
                        <img id="image-preview" src="" alt="Preview Gambar" class="img-fluid" style="max-width: 100px;">
                    </div>
                </div>
                    
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Add Kegiatan</button>
                     </div>
                
                </div>

 
            



            </form>
        </div>
    </div>
</div>  
 
{{-- edit   --}}
 @foreach ($whats as $items )
  <div class="modal fade" id="EditModal-{{ $items->id_whats }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-fullscreen">
        <div class="modal-content" style="background-color: #fff !important">
            <div class="modal-header  p-3">
                <h5 class="modal-title" id="exampleModalLabel">Edit Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" action="{{ route('whats.update', $items->id_whats) }}" method="post" enctype="multipart/form-data">
                 @method('PATCH')
                    @csrf
                <div class="modal-body">
                  
              

                    <div class="mb-3">
                        <label for="date-field" class="form-label">Images</label>
                        <input type="file" id="date-field" class="form-control" name="images">
                    
                        @if ($items->images)
                            <div class="mt-3">
                                <strong>Gambar Sebelumnya:</strong>
                                <div class="d-flex align-items-center mt-2">
                                    <img src="{{ asset('storage/whats/' . $items->images) }}" alt="{{ $items->images }}" class="img-fluid chocolat-image" width="100">
                                    <span class="ms-3">{{ $items->images }}</span> <!-- Menampilkan nama file gambar -->
                                </div>
                            </div>
                        @endif
                    </div>       
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn " >Edit Kegiatan</button>
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
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Pastikan file adalah gambar
        if (!file.type.startsWith("image/")) {
            Swal.fire({
                icon: "error",
                title: "File Tidak Valid!",
                text: "Harap unggah file gambar.",
            });
            event.target.value = ""; // Reset input file
            return;
        }

        const img = new Image();
        const objectURL = URL.createObjectURL(file);
        img.src = objectURL;

        img.onload = function () {
            const width = img.width;
            const height = img.height;

            if (width > 370 || height > 210) {
                // Gambar lebih besar dari batas, tidak diizinkan
                Swal.fire({
                    icon: "error",
                    title: "Ukuran Gambar Terlalu Besar!",
                    text: "Ukuran gambar harus 370x210 px.",
                });

                event.target.value = ""; // Reset input file
                document.getElementById("image-preview-container").style.display = "none";
            } else {
                document.getElementById("image-preview").src = img.src;
                document.getElementById("image-preview-container").style.display = "block";

                // Jika gambar lebih kecil, berikan peringatan tetapi tetap diizinkan
                if (width < 370 || height < 210) {
                    Swal.fire({
                        icon: "warning",
                        title: "Ukuran Gambar Kecil!",
                        text: "Ukuran gambar lebih kecil dari yang direkomendasikan (370x210 px), namun tetap diperbolehkan.",
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Gambar Sesuai!",
                        text: "Ukuran gambar sudah benar.",
                    });
                }
            }

            // Hapus URL sementara untuk menghindari memory leak
            URL.revokeObjectURL(objectURL);
        };

        img.onerror = function () {
            Swal.fire({
                icon: "error",
                title: "File Rusak!",
                text: "Gagal memuat gambar. Pastikan file tidak rusak.",
            });
            event.target.value = ""; // Reset input file
        };
    }
</script>

    
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
 <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
   
 <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
