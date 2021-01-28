@extends('indigo-layout::main')

@section('meta_title', _p('baselinker-client::pages.user.account.meta_title', 'Accounts') . ' - ' . config('app.name'))
@section('meta_description', _p('baselinker-client::pages.user.account.meta_description', 'Accounts in application'))

@push('head')

@endpush

@section('title')
    {{ _p('baselinker-client::pages.user.account.headline', 'Accounts') }}
@endsection

@section('create_button')
    <button class="frame__header-add" @click="AWEMA.emit('modal::connect:open')" title="{{ _p('baselinker-client::pages.user.account.connect_account', 'Connect account') }}"><i class="icon icon-plus"></i></button>
@endsection

@section('content')
    <div class="grid">
        <div class="cell-1-1 cell--dsm">
            <h4>{{ _p('baselinker-client::pages.user.account.accounts', 'Account') }}</h4>
            <div class="card">
                <div class="card-body">
                    <content-wrapper :url="$url.urlFromOnlyQuery('{{ route('baselinker_client.user.account.scope')}}', ['page', 'limit'], $route.query)"
                        :check-empty="function(test) { return !(test && (test.data && test.data.length || test.length)) }"
                        name="accounts_table">
                        <template slot-scope="table">
                            <table-builder :default="table.data">
                                <tb-column name="email" label="{{ _p('baselinker-client::pages.user.account.email', 'E-mail') }}"></tb-column>
                                <tb-column name="created_at" label="{{ _p('baselinker-client::pages.user.account.created_at', 'Created at') }}"></tb-column>
                                <tb-column name="manage" label="{{ _p('baselinker-client::pages.user.account.options', 'Options')  }}">
                                    <template slot-scope="col">
                                        <context-menu right boundary="table">
                                            <button type="submit" slot="toggler" class="btn">
                                                {{_p('baselinker-client::pages.user.account.options', 'Options')}}
                                            </button>
                                            <cm-button @click="AWEMA._store.commit('setData', {param: 'editAccount', data: col.data}); AWEMA.emit('modal::edit_account:open')">
                                                {{_p('baselinker-client::pages.user.account.edit', 'Edit')}}
                                            </cm-button>
                                            <cm-button @click="AWEMA._store.commit('setData', {param: 'deleteAccount', data: col.data}); AWEMA.emit('modal::delete_account:open')">
                                                {{_p('baselinker-client::pages.user.account.delete', 'Delete')}}
                                            </cm-button>
                                        </context-menu>
                                    </template>
                                </tb-column>
                            </table-builder>

                            <paginate-builder v-if="table.data"
                                :meta="table.meta"
                            ></paginate-builder>
                        </template>
                        @include('indigo-layout::components.base.loading')
                        @include('indigo-layout::components.base.empty')
                        @include('indigo-layout::components.base.error')
                    </content-wrapper>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')

    <modal-window name="connect" class="modal_formbuilder" title="{{ _p('baselinker-client::pages.user.account.connect_account', 'Connect account') }}">
        <form-builder name="connect"  :edited="true" url="{{ route('baselinker_client.user.account.store') }}"
                      @sended="AWEMA.emit('content::accounts_table:update')"
                      send-text="{{ _p('baselinker-client::pages.user.account.connect', 'Connect') }}" disabled-dialog>
            <fb-input name="email" label="{{ _p('baselinker-client::pages.user.account.email', 'E-mail') }}"></fb-input>
            <fb-input name="api_token" label="{{ _p('baselinker-client::pages.user.account.api_token', 'API token') }}"></fb-input>
        </form-builder>
    </modal-window>

    <modal-window name="edit_account" class="modal_formbuilder" title="{{ _p('baselinker-client::pages.user.account.edit_account', 'Edit account') }}">
        <form-builder url="{{ route('baselinker_client.user.account.update') }}/{id}" method="patch"
                      @sended="AWEMA.emit('content::accounts_table:update')"
                      send-text="{{ _p('baselinker-client::pages.user.account.save', 'Save') }}" store-data="editAccount">
            <div class="grid" v-if="AWEMA._store.state.editAccount">
                <fb-input name="email" label="{{ _p('baselinker-client::pages.user.account.email', 'E-mail') }}"></fb-input>
                <fb-input name="api_token" label="{{ _p('baselinker-client::pages.user.account.api_token', 'API token') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    <modal-window name="delete_account" class="modal_formbuilder" title="{{  _p('baselinker-client::pages.user.account.are_you_sure_delete', 'Are you sure delete?') }}">
        <form-builder :edited="true" url="{{route('baselinker_client.user.account.delete') }}/{id}" method="delete"
                      @sended="AWEMA.emit('content::accounts_table:update')"
                      send-text="{{ _p('baselinker-client::pages.user.account.confirm', 'Confirm') }}" store-data="deleteAccount"
                      disabled-dialog>

        </form-builder>
    </modal-window>
@endsection
