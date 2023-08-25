<!-- resources/views/events.blade.php -->

@foreach ($eventsPaginated as $event)
@if ($event instanceof \App\Models\Follower)
<li>{{ $event->name }} followed you!</li>
@elseif ($event instanceof \App\Models\Subscriber)
<li>{{ $event->name }} (Tier{{ $event->subscription_tier }}) subscribed to you!</li>
@elseif ($event instanceof \App\Models\Donation)
<li>{{ $event->name }} donated {{ $event->amount }} {{ $event->currency }} to you!</li>
@endif
@endforeach
