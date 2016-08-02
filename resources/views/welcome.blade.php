@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
                <div class="panel-body">

                    @if (Auth::check())
                    Online-wallets:
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('wallet.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> New wallet
                                </button>
                            </div>
                        </div>
                    </form>

                            @forelse (Auth::user()->getWallets() as $wallet)
                                <p>{{ $wallet->getId() }}</p>
                                <table border="1">
                                    <tr>
                                        <td>id</td>
                                        <td>currency</td>
                                        <td>amount</td>
                                    </tr>
                                    @foreach ($wallet->getCapitals() as $capital)
                                    <tr>
                                        <td>{{ $capital->getId() }}</td>
                                        <td>{{ $capital->getCurrency() }}</td>
                                        <td>{{ $capital->getAmount() }}</td>
                                    </tr>
                                    @endforeach
                                </table>

                            @empty
                                <p>No wallets</p>
                            @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
