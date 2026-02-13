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
                <h5 class="card-header">
                    @if($data->status == 1)
                        <span class="badge bg-label-success">فعال</span>
                    @else
                        <span class="badge bg-label-danger">غير فعال</span>
                    @endif
                </h5>
                <form class="card-body">
                    <h6>{{ __('all.investor') }}</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="multicol-username">{{__('all.name')}}</label>
                            <input type="text" id="multicol-username" class="form-control" value="{{ $data->userDetail->name }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="multicol-email">{{__('all.reference')}}</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="multicol-email" class="form-control" value="{{ $data->userDetail->refenece }}" disabled>
{{--                                <span class="input-group-text" id="multicol-email2">@example.com</span>--}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="multicol-username">{{__('all.profit')}}</label>
                            <input type="text" id="multicol-username" class="form-control" value="{{ $data->userDetail->profit }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="multicol-email">{{__('all.cash')}}</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="multicol-email" class="form-control" value="{{ $data->userDetail->cash }}" disabled>
                                {{--                                <span class="input-group-text" id="multicol-email2">@example.com</span>--}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="multicol-email">{{__('all.phone')}}</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="multicol-email" class="form-control" value="{{ $data->userDetail->phone }}" disabled>
                                {{--                                <span class="input-group-text" id="multicol-email2">@example.com</span>--}}
                            </div>
                        </div>
                    </div>
                    <hr class="my-4 mx-n4">
                    <h6>{{ __('all.withdraw') }}</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label" for="multicol-first-name">{{__('all.note')}}</label>
                            <input type="text" id="multicol-first-name" class="form-control" value="{{ $data->note }}" disabled>
                        </div>

                    </div>

                    <div class="row g-3 pt-3">
                        <div class="col-md-6">
                            <label class="form-label" for="multicol-first-name">{{__('all.method')}}</label>
                            <input type="text" id="multicol-first-name" class="form-control" value="{{ $data->method }}" disabled>
                        </div>
                        @if($data->method == 'western_union')
                            <div class="col-md-6">
                                <label class="form-label" for="multicol-first-name">{{__('all.wdr_passport')}}</label>
                                <input type="text" id="multicol-first-name" class="form-control" value="{{ $data->passport }}" disabled>
                            </div>
                        @elseif($data->method == 'bank_account')
                            <div class="col-md-6">
                                <label class="form-label" for="multicol-first-name">{{__('all.bank_account')}}</label>
                                <input type="text" id="multicol-first-name" class="form-control" value="{{ $data->bank_account }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="multicol-first-name">{{__('all.swift')}}</label>
                                <input type="text" id="multicol-first-name" class="form-control" value="{{ $data->swift }}" disabled>
                            </div>
                        @elseif($data->method == 'credit')
                            <div class="col-md-6">
                                <label class="form-label" for="multicol-first-name">{{__('all.card_no')}}</label>
                                <input type="text" id="multicol-first-name" class="form-control" value="{{ $data->card_no }}" disabled>
                            </div>
                        @elseif($data->method == 'zaincash')
                            <div class="col-md-6">
                                <label class="form-label" for="multicol-first-name">{{__('all.wdr_phone')}}</label>
                                <input type="text" id="multicol-first-name" class="form-control" value="{{ $data->phone }}" disabled>
                            </div>
                        @endif

                    </div>
                    <hr class="my-4 mx-n4">
                    <div class="pt-4">
{{--                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>--}}
                        <a type="reset" class="btn btn-label-secondary waves-effect" href="{{url()->previous()}}" >{{__('all.cancel')}}</a>
                    </div>
                </form>
            </div>

        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>
    </div>
@endsection
