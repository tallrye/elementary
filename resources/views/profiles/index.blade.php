@extends('layouts.app')

@section('content')
	{!! Html::breadcrumb('Kullanıcılar') !!}
    {!! Html::pagetitle('Tüm Kullanıcılar', ' ') !!}
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <a href="{{ route('profiles.admin.create') }}" class="btn sbold green"><i class="fa fa-plus"></i> Yeni Kullanıcı Oluştur</a>
                </div>
                <div class="portlet-body">
                    <table id="profiles" class="table table-striped table-bordered table-hover order-column">
                        <thead>
                            <tr>
                                <th>Ad Soyad</th>
                                <th>Görev</th>
                                <th>Organizasyon</th>
                                <th>E-Mail</th>
                                <th>Telefon No.</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    {!! HTML::deletemodal('deleteProfileModal', 'profiles.admin.delete', 'deleteProfile', 'name') !!}
@endsection

@section('pageLevelScripts')
    <script>
        $(document).ready(function() {
            $('#addNewRole').submit(function(e){
                e.preventDefault();
                kafka('addNewRole', 'newRoleModal', '/profiles/admin/store');
            });
            $('#deleteProfile').submit(function(e){
                e.preventDefault();
                kafka('deleteProfile', 'deleteProfileModal', '/profiles/admin/delete');
            });
            $(document).delegate('.deleteRow', 'submit', function(e){
                e.preventDefault();
                newman($(this), '/profiles/admin/fetch/', 'deleteProfile', 'deleteProfileModal');
            });
            var newDtOptions = {
                ajax: '{!! route('profiles.admin.load') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'title', name: 'title' },
                    { data: 'organization', name: 'organization' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'id', name: 'id' },
                ],
                editLink: function(data, type, row){
                    return '<a href="'+globalBaseUrl+ '/profiles/admin/detail/' + data + '" class="btn btn-sm green btn-outline filter-submit margin-bottom">Detay</a></form><form class="deleteRow" method="POST" action="permissions/fetch">{!! csrf_field() !!}<input type="hidden" name="id" value="'+data+'"><input type="submit" class="btn btn-sm red btn-outline filter-submit margin-bottom" value="Sil"></form>';
                },
                targets: 5,
            };
            activateTable('profiles', newDtOptions);

            var pusher = new Pusher('{{env("PUSHER_KEY")}}');
            var channel = pusher.subscribe('profiles-channel');
            channel.bind("refresh-profiles", function(data) {
                $('#profiles').DataTable().ajax.reload();
            });

        });
    </script>
@endsection