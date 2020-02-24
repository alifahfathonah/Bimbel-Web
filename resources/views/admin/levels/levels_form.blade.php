@csrf
<input type="hidden" name="course_level_id" value="{{ $level['id'] }}">

@component('components.form_input', ['name' => 'title', 'label' => 'Exam Title', 'value' => $sublevel['title'] ?? ''])
@endcomponent

@component('components.form_input', ['name' => 'minimum_score', 'label' => 'Minimum Score', 'type' => 'number', 'value'
=> $sublevel['minimum_score'] ?? '', 'prop' => 'min=0 max=100'])
@endcomponent

@component('components.form_input', ['name' => 'time', 'label' => 'Time (Minutes)', 'type' => 'number', 'value' =>
$sublevel['time'] ?? '', 'prop' => 'min=0'])
@endcomponent

@component('components.form_input', ['name' => 'description', 'label' => 'Description',])

@slot('input')
    <textarea class="form-control" id="description" name="description" placeholder="Description"
                rows=5>{{ old('description') ?? $sublevel['description'] ?? ''}}</textarea>
@endslot

@endcomponent
