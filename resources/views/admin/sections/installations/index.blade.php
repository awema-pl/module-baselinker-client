@extends('indigo-layout::installation')

@section('meta_title', _p('baselinker-client::pages.admin.installation.meta_title', 'Installation module Baselinker') . ' - ' . config('app.name'))
@section('meta_description', _p('baselinker-client::pages.admin.installation.meta_description', 'Installation module Baselinker client in application'))

@push('head')

@endpush

@section('title')
    <h2>{{ _p('baselinker-client::pages.admin.installation.headline', 'Installation module Baselinker') }}</h2>
@endsection

@section('content')
    <form-builder disabled-dialog="" url="{{ route('baselinker_client.admin.installation.index') }}" send-text="{{ _p('baselinker-client::pages.admin.installation.send_text', 'Install') }}"
    edited>
        <div class="section">
            <div class="section">
                {{ _p('baselinker-client::pages.admin.installation.will_be_execute_migrations', 'Will be execute package migrations') }}
            </div>
        </div>
    </form-builder>
@endsection
