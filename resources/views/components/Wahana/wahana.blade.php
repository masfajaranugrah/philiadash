
@extends('layouts.master')
@section('title') Wahana @endsection

@section('css')
 
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .pad{
        padding: 2rem !important
    }
    .w-3{
        width: 40rem;
    }
</style>
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Tables @endslot
@slot('title')Fasilitas @endslot
@endcomponent
 
   
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button class="btn  btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#showModal">Add Fasilitas</button>
            </div>
        
                             
               
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
                            
                            <td class="w-20 text-wrap">{!! $items->description !!}</td>
                             
                            <td class="w-20 text-wrap">{{ $items->location }}</td>
                            <td class="w-20 text-wrap">{{ 'Rp ' . number_format($items->price, 0, ',', '.') }}</td>
                            
                            <td>
                                @php
                                    $images = json_decode($items->images, true) ?? [];
                                @endphp
                            
                                <div style="display: grid; gap: 8px;">
                                    @if($images && is_array($images))
                                        @foreach($images as $image)
                                            <img src="{{ asset('storage/wahana/' . trim($image)) }}" 
                                                 alt="{{ $image }}" 
                                                 class="img-fluid" 
                                                 width="100">
                                        @endforeach
                                    @else
                                        <span class="text-muted">No Images</span>
                                    @endif
                                </div>
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
            <div class="modal-header bg-light pad">
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
                        <label for="validationTooltip02" class="form-label">Deskripsi</label>
                        <textarea class="ckeditor-classic" name="description" ></textarea>
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
                        <label for="images-field" class="form-label">Gambar</label>
                        <div id="image-upload-container">
                            <div class="d-flex align-items-center mb-2">
                                <input type="file" class="form-control image-input" name="images[]" accept="image/*" multiple onchange="previewImages()">
                                <button type="button" class="btn btn-primary ms-2" onclick="addImageInput()">+</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tempat untuk menampilkan preview gambar -->
                    <div class="mb-3" id="image-preview-container" style="display:none;">
                        <label class="form-label">Preview Gambar:</label>
                        <div id="image-preview" class="d-flex flex-wrap gap-2"></div>
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
@foreach ($wahana as $items)
  <div class="modal fade" id="EditModal-{{ $items->id_wahana }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-light pad">
                <h5 class="modal-title" id="exampleModalLabel">Edit Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" action="{{ route('update', $items->id_wahana) }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $items->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="ckeditor-classic" name="description">{{ $items->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" value="{{ $items->location }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" value="Rp {{ number_format($items->price, 0, ',', '.') }}" required>
                        <input type="hidden" name="price" value="{{ $items->price }}">
                    </div>

                  <!-- Preview Gambar Lama dengan tombol hapus -->
<div class="mb-3">
    <label class="form-label">Gambar Lama:</label>
    <div class="d-flex flex-wrap gap-2">
        @php
            $images = json_decode($items->images, true) ?? [];
        @endphp

        @if($images && is_array($images))
            @foreach ($images as $image)
                <div class="position-relative image-container">
                    <img src="{{ asset('storage/wahana/' . trim($image)) }}" class="rounded" width="100" height="100">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image" data-image="{{ $image }}">X</button>
                    <input type="hidden" name="old_images[]" value="{{ $image }}">
                </div>
            @endforeach
        @else
            <p>Tidak ada gambar lama.</p>
        @endif
    </div>
</div>

                    
                    <!-- Upload Gambar Baru -->
                    <div class="mb-3">
                        <label class="form-label">Tambah Gambar Baru:</label>
                        <div id="image-upload-container-edit-{{ $items->id_wahana }}">
                            <div class="d-flex align-items-center mb-2">
                                <input type="file" class="form-control image-input-edit" name="images[]" accept="image/*" multiple onchange="previewImagesEdit({{ $items->id_wahana }})">
                                <button type="button" class="btn btn-primary ms-2" onclick="addImageInputEdit({{ $items->id_wahana }})">+</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview Gambar Baru -->
                    <div class="mb-3" id="image-preview-container-edit-{{ $items->id_wahana }}" style="display:none;">
                        <label class="form-label">Preview Gambar:</label>
                        <div id="image-preview-edit-{{ $items->id_wahana }}" class="d-flex flex-wrap gap-2"></div>
                    </div>
                     
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Edit Fasilitas</button>
                </div>
            </form>
        </div>
    </div>
  </div>
@endforeach


 
 
<!--end row-->
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".remove-image").forEach(button => {
        button.addEventListener("click", function () {
            let imageContainer = this.closest(".image-container");
            let hiddenInput = imageContainer.querySelector("input[name='old_images[]']");

            // Hapus elemen dari DOM
            imageContainer.remove();

            // Kosongkan input hidden agar tidak dikirim ke backend
            if (hiddenInput) {
                hiddenInput.value = "";
            }
        });
    });
});

</script>
  <script>
    function previewImage(event, id) {
        let reader = new FileReader();
        reader.onload = function(){
            let output = document.getElementById('preview-' + id);
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    </script>
     

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script>
    function addImageInput() {
        let container = document.getElementById('image-upload-container');
        let newInputDiv = document.createElement('div');
        newInputDiv.classList.add('d-flex', 'align-items-center', 'mb-2');
    
        let newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.className = 'form-control image-input';
        newInput.name = 'images[]';
        newInput.accept = 'image/*';
        newInput.setAttribute('multiple', ''); // Bisa pilih banyak gambar
        newInput.addEventListener('change', previewImages);
    
        let removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn btn-danger ms-2';
        removeBtn.textContent = 'x';
        removeBtn.onclick = function() {
            container.removeChild(newInputDiv);
            previewImages(); // Update preview setelah input dihapus
        };
    
        newInputDiv.appendChild(newInput);
        newInputDiv.appendChild(removeBtn);
        container.appendChild(newInputDiv);
    }
  
    
    function previewImages() {
        let previewContainer = document.getElementById('image-preview-container');
        let previewDiv = document.getElementById('image-preview');
        previewDiv.innerHTML = ""; // Kosongkan preview sebelum memperbarui
    
        let allFiles = [];
        document.querySelectorAll('.image-input').forEach(input => {
            allFiles = allFiles.concat(Array.from(input.files)); // Gabungkan semua file dari setiap input
        });
    
        if (allFiles.length > 0) {
            previewContainer.style.display = "block";
        } else {
            previewContainer.style.display = "none";
        }
    
        allFiles.forEach(file => {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-fluid rounded';
                img.style.maxWidth = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.style.border = '1px solid #ddd';
                previewDiv.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }

 
 
    </script>  
 




 <script>
    function addImageInputEdit(id) {
    let container = document.getElementById(`image-upload-container-edit-${id}`);
    let newInputDiv = document.createElement('div');
    newInputDiv.classList.add('d-flex', 'align-items-center', 'mb-2');

    let newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.className = 'form-control image-input-edit';
    newInput.name = 'images[]';
    newInput.accept = 'image/*';
    newInput.multiple = true; 
    newInput.addEventListener('change', function () {
        previewImagesEdit(id);
    });

    let removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-danger ms-2';
    removeBtn.textContent = 'x';
    removeBtn.onclick = function () {
        container.removeChild(newInputDiv);
        previewImagesEdit(id);
    };

    newInputDiv.appendChild(newInput);
    newInputDiv.appendChild(removeBtn);
    container.appendChild(newInputDiv);
}


    function previewImagesEdit(id) {
    let previewContainerEdit = document.getElementById(`image-preview-container-edit-${id}`);
    let previewDivEdit = document.getElementById(`image-preview-edit-${id}`);
    previewDivEdit.innerHTML = ""; // Kosongkan preview sebelum memperbarui

    let allFiles = [];

    document.querySelectorAll(`#image-upload-container-edit-${id} .image-input-edit`).forEach(input => {
        Array.from(input.files).forEach(file => {
            allFiles.push(file);
        });
    });

    if (allFiles.length > 0) {
        previewContainerEdit.style.display = "block";
    } else {
        previewContainerEdit.style.display = "none";
    }

    allFiles.forEach(file => {
        let reader = new FileReader();
        reader.onload = function (e) {
            let img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-fluid rounded';
            img.style.maxWidth = '100px';
            img.style.height = '100px';
            img.style.objectFit = 'cover';
            img.style.border = '1px solid #ddd';
            previewDivEdit.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
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

<script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection