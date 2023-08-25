@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Total Revenue: ${{ $totalRevenue }}</p>
                    <p>Total Followers Gained: {{ $totalFollowersGained }}</p>
                    <p>Top Selling Items: </p>
                    <ul>
                        @foreach ($topSellingItems as $item)
                        <li>{{ $item->item_name }} - ${{ $item->total_amount }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Your Timeline') }}</div>

                <div class="card-body">
                    <!-- Events Container -->
                    <ul id="events-container" data-last-page="{{ $eventsPaginated->lastPage() }}">
                        @include('events') <!-- Include events partial view -->
                        <li>Thank you for being awesome</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/load-more.js') }}"></script>
@endsection
