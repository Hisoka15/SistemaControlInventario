@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    <h2 class="text-xl font-bold">Configuraciones</h2>
    @include('components.accordion', [
        'sections' => [
            ['key' => 1, 'name' => 'Roles', 'content' => view('configuration.roles.roles', ['roles' => $roles, 'permissions' => $permissions])->render()],
        ]
    ])
@endsection
