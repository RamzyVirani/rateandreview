@extends('admin.layouts.app')

@section('title')
    {{ $review->name }}
    <small>{{ $title }}</small>
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($review, ['route' => ['admin.reviews.update', $review->id], 'method' => 'patch', 'files' => true]) !!}

                    @include('rateandreview::fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection