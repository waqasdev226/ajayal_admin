@extends('portal.investor.view')



@section('investor_detail')

    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-lg-8 p-2 card-body">
            <h4 class="mb-2">Order Summary</h4>
            <p class="pb-2 mb-0">It can help you manage and service orders before,<br> during and after fulfilment.</p>
            <div class="bg-lighter p-4 rounded mt-4">
                <p class="mb-1">{{ __('all.cash') }}</p>
                <div class="d-flex align-items-center">
                    <h1 class="text-heading display-5 mb-1">{{ $cancel->currency }}  {{number_format($cancel->cash,2)}}</h1>
{{--                    <sub>/month</sub>--}}
                </div>
{{--                <div class="d-grid">--}}
{{--                    <button type="button" data-bs-target="#pricingModal" data-bs-toggle="modal" class="btn btn-label-primary waves-effect">Change Plan</button>--}}
{{--                </div>--}}
            </div>
            <div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="mb-0">{{ __('total_profit') }}</p>
                    <h6 class="mb-0">{{ $cancel->currency }}  {{number_format($cancel->total_profit,2)}}</h6>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="mb-0">{{ __('profit') }}</p>
                    <h6 class="mb-0">{{ $cancel->currency }}  {{number_format($cancel->profit,2)}}</h6>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="mb-0">{{ __('profit') }}</p>
                    <h6 class="mb-0">{{ $cancel->currency }}  {{number_format($cancel->profit,2)}}</h6>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="mb-0">{{ __('profit_per_day') }}</p>
                    <h6 class="mb-0">{{ $cancel->currency }}  {{number_format($cancel->profit_per_day,2)}}</h6>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="mb-0">{{ __('days') }}</p>
                    <h6 class="mb-0">{{ $cancel->currency }}  {{number_format($cancel->days,2)}}</h6>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center mt-3 pb-1">
                    <p class="mb-0">Total</p>
                    <h6 class="mb-0">{{ $cancel->currency }}  {{number_format($cancel->net_profit,2)}}</h6>
                </div>
                <div class="d-grid mt-3">
                    <form action="{{route('investor.cancelContract', $data->id)}}" method="POST">
                        @csrf
                    <button type="submit" class="btn btn-success waves-effect waves-light">
                        <span class="me-2">الغاء العقد</span>
                        <i class="ti ti-arrow-right scaleX-n1-rtl"></i>
                    </button>
                    </form>
                </div>

                <p class="mt-4 pt-2">By continuing, you accept to our Terms of Services and Privacy Policy. Please note that payments are non-refundable.</p>
            </div>
        </div>

        <div class="col-md-2"></div>
    </div>

@endsection
