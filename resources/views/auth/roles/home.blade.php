@extends('layouts.app')

@section('content')
	{!! Html::breadcrumb('Rol Tanımları') !!}
    {!! Html::pagetitle('Tüm Roller', ' ') !!}
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <a data-toggle="modal" href="#newRoleModal" class="btn sbold green"><i class="fa fa-plus"></i> Yeni Rol Oluştur</a>
                </div>
                <div class="portlet-body">
                    <table id="roles" class="table table-striped table-bordered table-hover order-column">
                        <thead>
                            <tr>
                                <th>Rol Adı</th>
                                <th>Açıklama</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    {!! HTML::formmodal('newRoleModal', 'Yeni Rol Ekle', 'roles.store', 'addNewRole', 'auth.roles._form') !!}
    {!! HTML::deletemodal('deleteRoleModal', 'roles.delete', 'deleteRole', 'name') !!}
@endsection

@section('pageLevelScripts')
    <script>
        $(document).ready(function() {
            $('#addNewRole').submit(function(e){
                e.preventDefault();
                kafka('addNewRole', 'newRoleModal', '/roles/store');
            });
            $('#deleteRole').submit(function(e){
                e.preventDefault();
                kafka('deleteRole', 'deleteRoleModal', '/roles/delete');
            });
            $(document).delegate('.deleteRow', 'submit', function(e){
                e.preventDefault();
                newman($(this), '/roles/fetch/', 'deleteRole', 'deleteRoleModal');
            });
            var newDtOptions = {
                ajax: '{!! route('roles.load') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'id', name: 'id' },
                ],
                editLink: function(data, type, row){
                    return '<a href="'+globalBaseUrl+ '/roles/edit/' + data + '" class="btn btn-sm green btn-outline filter-submit margin-bottom">Düzenle</a></form><form class="deleteRow" method="POST" action="permissions/fetch">{!! csrf_field() !!}<input type="hidden" name="id" value="'+data+'"><input type="submit" class="btn btn-sm red btn-outline filter-submit margin-bottom" value="Sil"></form>';
                },
                targets: 2,
            };
            activateTable('roles', newDtOptions);

            var pusher = new Pusher('{{env("PUSHER_KEY")}}');
            var channel = pusher.subscribe('roles-channel');
            channel.bind("refresh-role", function(data) {
                $('#roles').DataTable().ajax.reload();
            });

        });
    </script>
@endsection