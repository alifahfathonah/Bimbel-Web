@csrf

@component('components.form_input', [
    'label' => 'Name',
    'name' => 'name',
    'value' => $student['name'] ?? '',
])
@endcomponent

@component('components.form_input', [
    'label' => 'Username',
    'name' => 'username',
    'value' => $student['username'] ?? '',
])
@endcomponent
