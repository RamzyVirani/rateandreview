@isset($review)
@else
    <!-- User Id Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('user_id', 'User:') !!}
        {!! Form::select('user_id', $users, null, ['class' => 'form-control select2']) !!}
    </div>
@endisset

<!-- Rating Field -->
<div class="form-group col-sm-4">
    {!! Form::label('rating', 'Rating:') !!}
    {!! Form::select('rating', $range, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Rating Field -->
<div class="form-group col-sm-4">
    {!! Form::label('instance_type', 'Instance Type:') !!}
    {!! Form::select('instance_type', $types, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Rating Field -->
<div class="form-group col-sm-4">
    {!! Form::label('instance_id', 'Instance ID:') !!}
    {!! Form::number('instance_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Review Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('review', 'Review:') !!}
    {!! Form::textarea('review', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    {{--@if(!isset($review))--}}
    {{--{!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}--}}
    {{--@endif--}}
    {{--{!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}--}}
    <a href="{!! route('admin.reviews.index') !!}" class="btn btn-default">Cancel</a>
</div>
