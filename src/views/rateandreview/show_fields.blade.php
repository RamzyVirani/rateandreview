<!-- Id Field -->
<dt>{!! Form::label('id', 'Id:') !!}</dt>
<dd>{!! $review->id !!}</dd>

<!-- User Id Field -->
<dt>{!! Form::label('user_id', 'User:') !!}</dt>
<dd>{!! $review->user->details->full_name !!}</dd>

<!-- Rating Field -->
<dt>{!! Form::label('rating', 'Rating:') !!}</dt>
<dd>{!! $review->rating !!}</dd>

<!-- Instance Type Field -->
<dt>{!! Form::label('instance_type', 'Instance Type:') !!}</dt>
<dd>{!! $review->instance_type_text !!}</dd>

<!-- Rating Field -->
<dt>{!! Form::label('instance_id', 'Instance ID:') !!}</dt>
<dd>{!! $review->instance_id !!}</dd>

<!-- Review Field -->
<dt>{!! Form::label('review', 'Review:') !!}</dt>
<dd>{!! $review->review !!}</dd>

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $review->created_at !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $review->updated_at !!}</dd>


