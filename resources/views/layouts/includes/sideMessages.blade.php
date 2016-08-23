<!--BEGIN QUICK SIDEBAR -->
<a href="javascript:;" class="page-quick-sidebar-toggler">
    <i class="icon-login"></i>
</a>
<div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
    <div class="page-quick-sidebar">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Mesajlar</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                    <h3 class="list-heading">Kullanıcılar</h3>
                    <ul class="media-list list-items">
                        @foreach($chatters as $messageUser)
                        <li class="media" data-recipient="{{$messageUser->id}}">
                            <div class="media-status">
                                <span class="badge badge-success unreadMessageFrom" {{ (myMessageCountFrom($messageUser->id) > 0) ? '' : 'style=display:none;' }}>{{ myMessageCountFrom($messageUser->id) }}</span>
                            </div>
                            @if($messageUser->profile->photo)
                            <img class="media-object" src="{{ url($messageUser->profile->photo) }}" alt="...">
                            @else
                            <img class="media-object" src="{{ url('public/assets/team.png') }}" alt="...">
                            @endif
                            <div class="media-body">
                                <h4 class="media-heading">{{ $messageUser->name }}</h4>
                                <div class="media-heading-sub"> {{ $messageUser->title }} </div>
                            </div>
                        </li>
                        @endforeach
                        
                    </ul>
                </div>
                <div class="page-quick-sidebar-item" >
                    <div class="page-quick-sidebar-chat-user">
                        <div class="page-quick-sidebar-nav">
                            <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                <i class="icon-arrow-left"></i>Geri
                            </a>
                        </div>
                        <div class="loadEarlierMessages" id="loadEarlierMessagesFormTo"></div>
                        <div class="page-quick-sidebar-chat-user-messages" id="loadMessagesTo"></div>
                        <div class="page-quick-sidebar-chat-user-form" id="loadFormTo"></div>
                        <div class="sendingGifContainer">
                            {{ HTML::image('public/assets/ellipsis.gif', null, ['id' => 'sendingGif', 'class' => 'centeredImage']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END QUICK SIDEBAR -->