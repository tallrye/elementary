@extends('layouts.app')

@section('content')
    {!! Html::breadcrumb('Rol Tanımları', 'roles.index', 'Mevcut Rolü Güncelle') !!}
    {!! Html::pagetitle('Rolü Düzenle', '') !!}
    <div class="row">
        <div class="col-md-6 ">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <i class="icon-arrow-right font-green"></i>
                        <span class="caption-subject bold"> "{{ $role->name }}" Rolünü Yeniden Tanımla </span>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($role, array('route' => 'roles.update')) !!}
                        {!! Form::hidden('id', null) !!}
                        @include('auth.roles._form')
                        <div class="form-actions noborder">
                            <button type="submit" class="btn blue">Kaydet</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green-soft">
                        <i class="icon-arrow-right font-green-soft"></i>
                        <span class="caption-subject bold"> "{{ $role->name }}" Rolüne Yetki Ver</span>
                    </div>
                    @can('manage_permissions')
                    <div class="actions">
                        <div class="btn-group">
                            <a data-toggle="modal" href="#newPermissionModal" class="btn btn-outline btn-circle green"><i class="fa fa-plus"></i> Yeni Yetki Ekle</a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="portlet-body form">
                    {!! Form::open(array('route' => 'roles.addpermission')) !!}
                        {!! Form::hidden('role_id', $role->id) !!}
                        <div class="input-group">
                            <select id="permission_id" name="permission_id" class="form-control select2">
                                <option></option>
                            </select>
                            <span class="input-group-btn">
                                <button class="btn green-soft" type="submit">
                                    Yetki Ver <i class="fa fa-long-arrow-right fa-fw"></i></button>
                            </span>
                        </div>
                    {!! Form::close() !!}
                    
                </div>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-yellow">
                        <i class="icon-arrow-right font-yellow"></i>
                        <span class="caption-subject bold"> "{{ $role->name }}" Rolü Şunları Yapabilir</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <table class="table table-light table-hover">
                        @if($role->permissions->isEmpty())
                            Bu rol için verilmiş herhangi bir yetki yok.
                        @endif
                        @foreach($role->permissions as $permission)
                            <tr>
                                {!! Form::open(array('route' => 'roles.removepermission')) !!}
                                    {!! Form::hidden('role_id', $role->id) !!}
                                    {!! Form::hidden('permission_id', $permission->id) !!}
                                    <td><button type="submit" class="btn btn-sm red"><i class="fa fa-close"></i></button> {{ $permission->name }} ({{ $permission->description }})</td>
                                {!! Form::close() !!}
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    {!! HTML::formmodal('newPermissionModal', 'Yeni Yetki Ekle', 'permissions.store', 'addNewPermission', 'auth.permissions._form') !!}

@endsection

@section('pageLevelScripts')
    <script>
        $('#addNewPermission').submit(function(e){
            e.preventDefault();
            kafka('addNewPermission', 'newPermissionModal', '/permissions/store');
        });
        var newS2Options = {
            placeholder:"Yetki Seç",
            searchUrl: '/permissions/search/{{ $role->id }}',
        };
        activateS2('permission_id', newS2Options);
    </script>
@endsection