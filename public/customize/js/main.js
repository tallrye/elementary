$(document).ready(function(){
    /* Catch the event when user hover above .unreadNotification
    *  then submit a form.
    */
	$(document).delegate('.unreadNotification', 'mouseenter', function(){
		$(this).find('.readIt').submit();
	});

    /* Catch the event when user submits .readIt form
    *  then call another function from postOffice.js
    */
	$(document).delegate('.readIt', 'submit', function(e){
        e.preventDefault();
       	readTheNotification($(this));
    });

    /* Catch the event when user submits .sideMessageForm form
    *  then call another function from postOffice.js
    */
    $(document).delegate('.sideMessageForm', 'submit', function(e){
        e.preventDefault();
       	chatter($(this), '/chat/sendmessage');
    });

    /* Catch the event when user submits .loadEarlierForm form
    *  then call another function from postOffice.js
    */
    $(document).delegate('.loadEarlierForm', 'submit', function(e){
        e.preventDefault();
        earlier($(this), '/chat/loadearlier');
    });
});

