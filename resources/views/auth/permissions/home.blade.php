@extends('layouts.app')

@section('content')
    {!! Html::breadcrumb('Yetkiler') !!}
    {!! Html::pagetitle('Tüm Yetkiler', '') !!}
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <a data-toggle="modal" href="#newPermissionModal" class="btn sbold green"><i class="fa fa-plus"></i> Yeni Yetki Oluştur</a>
                </div>
                <div class="portlet-body">
                    <table id="permissions" class="table table-striped table-bordered table-hover order-column">
                        <thead>
                            <tr>
                                <th>Yetki Adı</th>
                                <th>Açıklaması</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    {!! HTML::formmodal('newPermissionModal', 'Yeni Yeki Ekle', 'permissions.store', 'addNewPermission', 'auth.permissions._form') !!}
    {!! HTML::formmodal('editPermissionModal', 'Mevcut Yetkiyi Düzenle', 'permissions.update', 'updatePermission', 'auth.permissions._form', true) !!}
    {!! HTML::deletemodal('deletePermissionModal', 'permissions.delete', 'deletePermission', 'name') !!}
@endsection

@section('pageLevelScripts')
    <script>
        $(document).ready(function() {
            $('#addNewPermission').submit(function(e){
                e.preventDefault();
                kafka('addNewPermission', 'newPermissionModal', '/permissions/store');
            });
            $('#updatePermission').submit(function(e){
                e.preventDefault();
                kafka('updatePermission', 'editPermissionModal', '/permissions/update');
            });
            $('#deletePermission').submit(function(e){
                e.preventDefault();
                kafka('deletePermission', 'deletePermissionModal', '/permissions/delete');
            });
            $(document).delegate('.fetchRow', 'submit', function(e){
                e.preventDefault();
                newman($(this), '/permissions/fetch/', 'updatePermission', 'editPermissionModal');
            });
            $(document).delegate('.deleteRow', 'submit', function(e){
                e.preventDefault();
                newman($(this), '/permissions/fetch/', 'deletePermission', 'deletePermissionModal');
            });
            var newDtOptions = {
                ajax: '{!! route('permissions.load') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'id', name: 'id' },
                ],
                editLink: function(data, type, row){
                    return '<form class="fetchRow" method="POST" action="permissions/fetch">{!! csrf_field() !!}<input type="hidden" name="id" value="'+data+'"><input type="submit" class="btn btn-sm green btn-outline filter-submit margin-bottom" value="Düzenle"></form><form class="deleteRow" method="POST" action="permissions/fetch">{!! csrf_field() !!}<input type="hidden" name="id" value="'+data+'"><input type="submit" class="btn btn-sm red btn-outline filter-submit margin-bottom" value="Sil"></form>';
                },
                targets: 2,
            };
            activateTable('permissions', newDtOptions);
            

            var pusher = new Pusher('{{env("PUSHER_KEY")}}');
            var channel = pusher.subscribe('roles-channel');
            channel.bind("refresh-permissions", function(data) {
                $('#permissions').DataTable().ajax.reload();
            });
        });
    </script>
    
@endsection
