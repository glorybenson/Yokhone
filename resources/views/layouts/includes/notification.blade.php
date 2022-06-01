<div class="notifications">
    <div class="topnav-dropdown-header">
        <span class="notification-title">Notifications</span>
        <a href="javascript:void(0)" class="clear-noti"> <i class="feather-x-circle"></i> </a>
    </div>
    <div class="noti-content">
        <ul class="notification-list">
            <?php $notifications = auth()->user()->unreadNotifications; ?>
            @if(isset($notifications))
            @forelse($notifications as $notification)
            <li class="notification-message">
                <a>
                    <div class="media">
                        <div class="media-body">
                            <form action="" method="POST">
                                <i onclick="deleteNotification(this, '{{$notification->id}}', '{{csrf_token()}}')" class="feather-x-circle close-notification"></i>
                            </form>
                            <p class="noti-details"><span class="noti-title"></span> {{__($notification->data['message'])}}
                                <span class="noti-title">
                                    @if($notification->data['data'] != ' ')
                                    <b>
                                        <spaceless> - {{$notification->data['data']}}</spaceless>
                                    </b>
                                    @else
                                    @endif
                                </span>
                            </p>
                            <p class="noti-time"><span class="notification-time">{{$notification->created_at->diffForHumans()}}</span></p>
                        </div>
                    </div>
                </a>
            </li>
            @empty
            @endforelse
            @endif

        </ul>
    </div>
    <div class="topnav-dropdown-footer">
        <a href="{{ route('delete.all.notification') }}"
           onclick="return confirm('{{__('Are you sure you want to clear all notifications?')}}')">
            {{__('Clear all Notifications')}}
        </a>
    </div>
</div>

<script>
    function deleteNotification(e, id, token) {
        e.closest("li").remove();
        $.ajax({
            url: "{{ route('delete.notification') }}",
            type: "POST",
            data: {
                _token: token,
                not_id: id
            },
            success: function(data) {
                // console.log(data)
            },
        });
    }
</script>
