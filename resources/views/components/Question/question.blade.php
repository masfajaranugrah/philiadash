@extends('layouts.master')
@section('title') FAQ @endsection
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
@slot('title')Fasilitas @endslot
@endcomponent
 
 
@session("success")
toastr.success("{{ $value }}", "Success");
@endsession
 

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button class="btn  btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#showModal">Add FAQ</button>
            </div>
            <div class="card-body">
                <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                            <th>Action</th>
                      
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $question as $items )
                        <tr>
                            <td class="w-20 text-wrap">{{ $items->pertanyaan }}</td>
                            
                            <td class="w-20 text-wrap">{{ $items->jawaban }}</td>
                             
                            
                            <td>
                                <div class="d-flex gap-2">
                                    <div class="edit">
                                        <button class="btn btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#EditModal-{{ $items->id_question }}">Edit</button>
                                    </div>
                                    <div class="remove">
                                        <form id="delete-form-{{ $items->id_question }}" action="{{ route('delete-question', $items->id_question) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $items->id_question }}')">Delete</button>
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
            <form class="tablelist-form" action="{{route('create-question')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="mb-3" >
                        <label for="id-field" class="form-label">Pertanyaan</label>
                        <input type="text" class="form-control" name="pertanyaan" id="validationTooltip01" placeholder="Masukkan Pertanyaan"  required>
                    </div>

                    <div class="mb-3">
                        <label for="customername-field" class="form-label">Jawaban</label>
                        <input type="text" class="form-control" name="jawaban" id="validationTooltip02"  placeholder="Masukkan Jawaban"   required>
                     
                    </div>

                  
                </div>

 
            



                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Add FAQ</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 
{{-- edit   --}}
@foreach ($question as $items )
  <div class="modal fade" id="EditModal-{{ $items->id_question }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" action="{{ route('update-question', $items->id_question) }}" method="post" enctype="multipart/form-data">
                 @method('PATCH')
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3" >
                            <label for="id-field" class="form-label">Pertanyaan</label>
                            <input type="text" class="form-control" name="pertanyaan" value="{{ $items->pertanyaan }}" id="validationTooltip01" placeholder="Masukkan Pertanyaan"  required>
                        </div>
    
                        <div class="mb-3">
                            <label for="customername-field" class="form-label">Jawaban</label>
                            <input type="text" class="form-control" name="jawaban" id="validationTooltip02" value="{{ $items->jawaban }}" placeholder="Masukkan Jawaban"   required>
                         
                        </div>
    
                      
                    </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Edit FAQ</button>
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

<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>

 <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
