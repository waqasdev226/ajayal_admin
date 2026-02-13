@extends('layouts.app')

@push('upper-style-1')

@endpush


@push('upper-style-2')
    {{--    <link id="pagestyle" href="https://demos.creative-tim.com/soft-ui-dashboard-pro/assets/css/soft-ui-dashboard.min.css?v=1.0.9" rel="stylesheet">--}}
@endpush
@section('content')

    <div class="content-wrapper">

        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="py-3 mb-2">
                @foreach($breadcrumb as $url_list)
                    @if(end($breadcrumb) == $url_list)
                        {{ $url_list }}
                    @else
                        <span class="text-muted fw-light">{{ $url_list }} /</span>
                    @endif
                @endforeach
            </h4>

            <div class="card mb-4">
                <form class="card-body" action="{{ route('updateSetting') }}" method="post" >
                    @csrf
                    <h6>{{ __('all.setting') }}</h6>
                    <div class="row g-3 pt-3">
                        <div class="col-md-6">
                            <label class="form-label" for="min_ratio">{{__('all.min_ratio')}}</label>
                            <input type="text" id="min_ratio" name="min_ratio" class="form-control" value="{{ $data->min_ratio }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="max_ratio">{{__('all.max_ratio')}}</label>
                            <input type="text" id="max_ratio" name="max_ratio" class="form-control" value="{{ $data->max_ratio }}">
                        </div>
                    </div>
                    <div class="row g-3 pt-3">
                        <div class="col-md-6">
                            <label class="form-label" for="profit_release_day">{{__('all.profit_release_day')}}</label>
                            <input type="text" id="profit_release_day" name="profit_release_day" class="form-control" value="{{ $data->profit_release_day }}">
                        </div>
                        <div class="col-md-6">
{{--                            <label class="form-label" for="max_ratio">{{__('all.max_ratio')}}</label>--}}
{{--                            <input type="text" id="max_ratio" name="max_ratio" class="form-control" value="{{ $data->max_ratio }}">--}}
                        </div>
                    </div>
                    <hr class="my-4 mx-n4">
                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">{{__('all.submit')}}</button>
                        <a type="reset" class="btn btn-label-secondary waves-effect" href="{{url()->previous()}}" >{{__('all.cancel')}}</a>
                    </div>
                </form>
            </div>

        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>
    </div>
@endsection
