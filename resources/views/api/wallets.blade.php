@forelse ($wallets as $wallet)
{{ $wallet->getId()."\n" }}
@foreach ($wallet->getCapitals() as $capital)
{{ $capital->getCurrency() }} {{ $capital->getAmount() }}
@endforeach
@empty
No wallets
@endforelse