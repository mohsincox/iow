@extends('layouts.admin_layout')
@section('title')
    Igloo - Career
@endsection
@section('stylesheet')
    <link href="{{ asset('default/assets/fromcdn/bootstrap.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
@endsection
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Career</h1>
            </div>
            <!-- /page header -->

            <!-- Grid -->
            <div class="row">

                <!-- Grid Item -->
                <div class="col-12">

                    <!-- Card -->
                    <div class="dt-card">

                        <!-- Card Header -->
                        <div class="dt-card__header">

                            <!-- Card Heading -->
                            <div class="dt-card__heading">
                                <h3 class="dt-card__title">Hire employee requirement</h3>
                            </div>
                            <!-- /card heading -->

                        </div>
                        <!-- /card header -->

                        <!-- Card Body -->
                        <div class="dt-card__body">
                            @if(session()->has('status'))
                                {!! session()->get('status') !!}
                            @endif
                            <form method="post" action="{{route('admin.career')}}">
                                @csrf
                                <textarea id="summernote" name="editordata">{{ (isset($career->des )) ? $career->des : null}} </textarea>
                                <button class="btn btn-primary">Submit</button>

                            </form>

                        </div>
                        <!-- /card body -->

                    </div>
                    <!-- /card -->

                </div>
                <!-- /grid item -->

            </div>
            <!-- /grid -->

        </div>
        <!-- /site content -->

        <!-- Footer -->
        <footer class="dt-footer">
            Copyright Company Name © 2019
        </footer>
        <!-- /footer -->

    </div>
@endsection
@section('script')
    <script src="{{ asset('default/assets/fromcdn/jquery.js') }}"></script>
    <script src="{{ asset('default/assets/fromcdn/bootstrap.js') }}"></script>
    <script src="{{ asset('default/assets/fromcdn/summernote.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection