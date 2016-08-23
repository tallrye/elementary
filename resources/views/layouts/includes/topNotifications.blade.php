<!-- BEGIN NOTIFICATION DROPDOWN -->
<li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <i class="icon-bell"></i>
        <span class="badge badge-default" {{ ($unread > 0) ? '' : 'style=display:none;' }} id="unreadNotificationCount">{{ $unread }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="external">
            <h3>
                <span class="bold">bildirimleriniz</span>
            </h3>
            <a href="{{ url('/profiles/myprofile') }}">tüm bildirimler</a>
        </li>
        <li>
            <ul id="topNotificationsUl" class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                @foreach($notifications as $notification)
                <li class="{{ ($notification->isRead) ? '' : 'unreadNotification' }} singleNotification">
                    <a href="{{ url($notification->action_link) }}">
                        <span class="details">
                            <span class="label label-sm label-icon label-{{ $notification->type->label }}" >
                                <i class="fa {{ $notification->type->icon }}"></i>
                            </span> 
                            <span class="notificationName">{{ $notification->type->name }}</span>
                            <div class="notificationDescription">
                            {{ $notification->description }} {{ $notification->action_name }}
                            </div>
                        </span>
                    </a>
                    <form class="readIt" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $notification->id }}">
                    </form>
                </li>
                @endforeach
            </ul>
        </li>
    </ul>
</li>
<!-- END NOTIFICATION DROPDOWN -->
<!-- BEGIN INBOX DROPDOWN -->
<!-- <li class="dropdown dropdown-quick-sidebar-toggler" >
    <a href="javascript:;" class="dropdown-toggle">
        <i class="icon-bubbles noBeforeEnvelope"></i>
        <span class="badge badge-default"> 4 </span>
    </a>
</li> -->

<!-- END INBOX DROPDOWN -->
