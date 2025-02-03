@extends('layouts.master')
@section('title') @lang('translation.validation') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1')
Forms
@endslot
@slot('title')
Forms Validation
@endslot
@endcomponent



    <div class="row  ">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Input FAQ</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <p class="text-muted">
                        Silahkan masukan wahana yang ingin anda tambahkan di halaman
                    </p>

                    <form class=" g-3 needs-validation" novalidate action="{{route('create-question')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class=" position-relative mt-2">
                            <label for="validationTooltip01" class="form-label">Pertanyaan</label>
                            <input type="text" class="form-control" name="pertanyaan" id="validationTooltip01"  required>
                            <div class="invalid-tooltip">
                                Pertanyaan tidak boleh Kosong!
                            </div>
                        
                        </div>
                        <div class=" position-relative mt-2">
                            <label for="validationTooltip02" class="form-label">jawaban</label>
                            <input type="text" class="form-control" name="jawaban" id="validationTooltip02" required>
                            <div class="invalid-tooltip">
                                Jawaban tidak boleh Kosong!
                            </div>
                        </div>
                       
                        <div class="col-12 mt-2">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
        
    </div>
    <!-- end row -->

</div>

@endsection
@section('script')
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
