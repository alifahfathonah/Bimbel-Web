@csrf

@component('components.form_input',[
    'name' => 'username',
    'label' => 'Username',
    'value' => $username ?? ''
])
@endcomponent

@component('components.form_input',[
    'name' => 'name',
    'label' => 'Name',
    'value' => $name ?? ''
])
@endcomponent

@component('components.form_input',[
    'name' => 'email',
    'label' => 'Email Address',
    'value' => $email ?? ''
])
@endcomponent

@component('components.form_input',[
    'name' => 'password',
    'label' => 'Password',
    'type' => 'password',
])
@endcomponent

@component('components.form_input',[
    'name' => 'password_confirmation',
    'label' => 'Confirm Password',
    'type' => 'password'
])
@endcomponent

{{ $slot }}
