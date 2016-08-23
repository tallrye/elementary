/*
* This function updates the database according to the data 
* submitted from a bootstrap modal via Ajax. See example on
* Adding a New Role, Deleting a New Role etc.
* 
* @param {HTMLElement} from -> The form that is being submitted
* @param {HTMLElement} modal -> The bootstrap modal which will be closed after transaction
* @param {String} to -> The URL that the data will be posted to
* @returns {Response} -> Displays a response message on the screen using toastr.js
*/
function kafka(from, modal, to){
    var $form = $('#'+from);
    var serializedData = $form.serialize();
    request = $.ajax({
        data: serializedData,
        type: 'POST',
        url: globalBaseUrl + to,
        success: function (response) {
            $('#'+modal).modal('hide');
            $form[0].reset();
            toastr.success(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var fullErrors = "";
            jQuery.each( JSON.parse(xhr.responseText), function( i, val ) {
                fullErrors += val + '<br>';
                $('label[for="'+i+'"]').pulsate({
                      color: "#f20000",
                      repeat: 2, 
                });
                return fullErrors;
            });
            toastr.error(fullErrors);
        },
    });
}

/*
* This function updates the database according to the data 
* submitted from a page via Ajax. The difference between this
* function and kafka() function is that the form on kafka() 
* comes from a bootstrap modal. See example at IEMS project on 
* Employee update 
* 
* @param {HTMLElement} from -> The form that is being submitted
* @param {String} to -> The URL that the data will be posted to
* @returns {Response} -> Displays a response message on the screen using toastr.js
*/
function goethe(from, to){
    var $form = $('#'+from);
    var serializedData = $form.serialize();
    request = $.ajax({
        data: serializedData,
        type: 'POST',
        url: globalBaseUrl + to,
        success: function (response) {
            toastr.success(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var fullErrors = "";
            jQuery.each( JSON.parse(xhr.responseText), function( i, val ) {
                fullErrors += val + '<br>';
                $('label[for="'+i+'"]').pulsate({
                      color: "#f20000",
                      repeat: 2, 
                });
                return fullErrors;
            });
            toastr.error(fullErrors);
        },
    });
}

/*
* This function sends side messages to the database
* 
* @param {HTMLElement} from -> The form that is being submitted
* @param {String} to -> The URL that the data will be posted to
* @returns {Response} -> Displays a response message on the screen using toastr.js
*/
function chatter(submitted, to){
    var $form = submitted;
    var serializedData = $form.serialize();
    $('#sendingGif').addClass('active');
    request = $.ajax({
        data: serializedData,
        type: 'POST',
        url: globalBaseUrl + to,
        success: function (response) {
            $.ajax({
                type: 'GET',
                url: globalBaseUrl + '/chat/fetchmessage/'+response[0].id,
                success: function (response) {
                    $('.page-quick-sidebar-chat-user-messages').append(response);
                    $('.page-quick-sidebar-chat-user-messages').slimScroll({
                        scrollTo: '1000000px'
                    });
                    submitted.find('input[name="text"]').val('');
                    submitted.find('input[name="text"]').focus();
                    $('#sendingGif').removeClass('active');
                },
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error('Hatalar var.');
        },
    });
}

/*
* This function gets earlier messages in a conversation from database
* 
* @param {HTMLElement} submitted -> The form that is being submitted
* @param {String} to -> The URL that the data will be posted to
* @returns {Response} -> Displays a response message on the screen using toastr.js
*/
function earlier(submitted, to){
    var $form = submitted;
    var serializedData = $form.serialize();
    var skipped = $form.find('input[name="skip"]').val();
    $form.find('input[name="skip"]').val(parseInt(skipped) + 10);
    $('#sendingGif').addClass('active');
    request = $.ajax({
        data: serializedData,
        type: 'POST',
        url: globalBaseUrl + to,
        success: function (response) {
            if(response.messagelength < 10){
                $form.hide();
            }
            $('.page-quick-sidebar-chat-user-messages').prepend(response.messages);
            $('#sendingGif').removeClass('active');
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error('Hatalar var.');
        },
    });
}

/*
* This function loads the last sent message to the side messaging module.
* 
* @param {HTMLElement} data -> ID of the message to fetch from database
* @returns {Function} -> Loads the generated HTML into the DOM
*/
function getLatestMessage(data){
    $.ajax({
        type: 'GET',
        url: globalBaseUrl + '/chat/newmessage/'+data,
        success: function (response) {
            $('.page-quick-sidebar-chat-user-messages').append(response.html);
            $('.page-quick-sidebar-chat-user-messages').slimScroll({
                scrollTo: '1000000px'
            });
            $('#unreadMessageCount').text(response.unreadTotal);
            $('#unreadMessageCount').show();
            $('li.media[data-recipient="'+response.lastSender+'"]').find('.unreadMessageFrom').text(response.unredFromSender);
            $('li.media[data-recipient="'+response.lastSender+'"]').find('.unreadMessageFrom').show();
        },
    });
}

/*
* This function sends a trigger to the back-end when a message is read
* 
* @param {HTMLElement} submitted -> The form that is being submitted
* @param {String} token -> Laravel's CSRF Token
* @returns {Function} -> Updates DOM accordingly
*/
function readAMessage(submitted, token){
    var msg = submitted.data('message');
    $.ajax({
        data: { _token : token},
        type: 'POST',
        url: globalBaseUrl + '/chat/read/'+msg,
        success: function (response) {
            submitted.removeClass('unreadMessage');
            $('#unreadMessageCount').text(response.unreadTotal);
            if(response.unreadTotal == 0){
                $('#unreadMessageCount').hide();
            }else{
                $('#unreadMessageCount').show();
            }
            $('li.media[data-recipient="'+response.lastSender+'"]').find('.unreadMessageFrom').text(response.unredFromSender);
            if(response.unredFromSender == 0){
                $('li.media[data-recipient="'+response.lastSender+'"]').find('.unreadMessageFrom').hide();
            }else{
                $('li.media[data-recipient="'+response.lastSender+'"]').find('.unreadMessageFrom').show();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error('Hatalar var.');
        },
    });
}

/*
* This function gets data from database and then 
* fires up a bootstrap modal form. See example on
* Roles Listing Table when user wants to delete/update
* a record through a bootstrap modal, without visiting
* another page
* 
* @param {HTMLElement} submitted -> The form that is being getting data of which ID to fetch from database
* @param {String} to -> The URL that the data will be getting from
* @param {HTMLElement} from -> The bootsrap modal form that will be updated when data is got
* @param {HTMLElement} modal -> The bootstrap modal which will be shown after transaction
* @returns {Function} -> Shows the boostrap modal form.
*/
function newman(submitted, to, from, modal){
    var record_id = submitted.find('input[name="id"]').val();
    var serializedData = submitted.serialize();
    request = $.ajax({
        data: record_id,
        type: 'GET',
        url: globalBaseUrl + to + record_id,
    });
    request.done(function (response, textStatus, jqXHR){
        $form = $('#'+from);
        for (i in response) {
            $form.find('[name="' + i + '"]').val(response[i]);
            $form.find('[name="' + i + '"]').focus();
        }
        $('#'+modal).modal('show');
    });
}

/*
* This function gets data from database. See example at IEMS project on 
* Human edit page, at Notes section, for edit existing note's importance level
* dropdown. 
* 
* @param {String} to -> The URL that the data will be getting from
* @returns {Array} -> Array of the data that returns from the database
*/
function halley(to){
    var html = "";
    request = $.ajax({
        type: 'GET',
        url: globalBaseUrl + to,
        success: function (response) {
            html = response;
        },
    });
    return html;
    
}

/*
* This function gets data from database in formatted in key-value pairs.
* Use this function when you create a select2 dropdown on the client side.
* 
* @param {String} to -> The URL that the data will be getting from
* @returns {Array} -> Array of the data that returns from the database
*/
function hubble(to){
    var array = {};
    request = $.ajax({
        type: 'GET',
        url: globalBaseUrl + to
    });
    request.done(function (response, textStatus, jqXHR){
        for (i in response) {
            array[i] = response[i];
        }
    });
    return array;
}

/*
* This function posts data to database when a user hovers above
* an unread notification.
* 
* @param {HTMLElement} submitted -> The form that is being posting data to the database
* @returns {Function} -> Update unread notification count on the front end
*/
function readTheNotification(submitted){
    var $form = submitted;
    var serializedData = $form.serialize();
    request = $.ajax({
        data: serializedData,
        type: 'POST',
        url: globalBaseUrl + '/notifications/read',
        success: function (response) {
            if(response == 0){
                $('#unreadNotificationCount').hide();
            }else{
                $('#unreadNotificationCount').text(response);
            }
            $form.parents('.unreadNotification').removeClass('unreadNotification');
        },
        error: function (xhr, ajaxOptions, thrownError) {
           toastr.error('Hatalar var.');
        },
    });
}

/*
* This function posts data to database when Pusher says that
* there are new notifications no fetch.
* 
* @param {HTMLElement} submitted -> The form that is being posting data to the database
* @param {HTMLElementInput} csrf -> Laravel's CSRF field to generate the form for recently appended notifications
* @returns {Function} -> Update the front end and show the most recent notifications.
*/
function getMyNotifications(submitted,csrf){
    var $form = submitted;
    var serializedData = $form.serialize();
    request = $.ajax({
        data: serializedData,
        type: 'POST',
        url: globalBaseUrl + '/notifications/get',
        success: function (response) {
            for (i in response) {
                var html = '<li class="unreadNotification singleNotification"><a href="'+globalBaseUrl+response[i].action_link+'"><span class="details"><span class="label label-sm label-icon label-'+response[i].type.label+'" ><i class="fa '+response[i].type.icon+'"></i></span> <span class="notificationName">'+response[i].type.name+'</span><div class="notificationDescription">'+response[i].description+' '+response[i].action_name+'</div></span></a><form class="readIt" method="POST">'+csrf+'<input type="hidden" name="id" value="'+response[i].id+'"></form></li>'
                $('#topNotificationsUl').prepend(html);
            }
            $('#unreadNotificationCount').show();
            $('#unreadNotificationCount').text(response.length);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error('Hatalar var.');
        },
    });
}

/*
* This function activates a datatable with given options.
* 
* @param {HTMLElement} table -> The Datatable ID to activate
* @param {Array} options -> Options of the Datatable
* @returns {Function} -> Activate the Datatable
*/
function activateTable(table, options){
    $('#'+table).DataTable({
        processing: true,
        serverside: true,
        ajax: options.ajax,
        columns: options.columns,
        buttons: [
            { extend: 'print', className: 'btn dark btn-outline' },
            { extend: 'pdf', className: 'btn green btn-outline' },
            { extend: 'excel', className: 'btn yellow btn-outline ' },
            { extend: 'colvis', className: 'btn dark btn-outline', text: 'Kolon Seç'},
            {
                text: 'Yenile',
                className: 'btn purple btn-outline ',
                action: function(e, dt, node, config) {
                    dt.ajax.reload();
                }
            }
        ],
        columnDefs: [
            {   
                render: options.editLink,
                targets: options.targets
            },
            { visible: true, targets: [0] }
        ],
        pageLength: 10,
        dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        "language": {
            "lengthMenu": 'Her sayfada <select>'+
            '<option value="10">10</option>'+
            '<option value="20">20</option>'+
            '<option value="30">30</option>'+
            '<option value="40">40</option>'+
            '<option value="50">50</option>'+
            '<option value="-1">Tümü</option>'+
            '</select> adet göster'
        } 
    });
}

/*
* This function activates a simpler datatable with given options. 
* 
* @param {HTMLElement} table -> The Datatable ID to activate
* @param {Array} options -> Options of the Datatable
* @returns {Function} -> Activate the Datatable
*/
function activateSimpleTable(table, options){
    $('#'+table).DataTable({
        processing: true,
        serverside: true,
        ajax: options.ajax,
        columns: options.columns,
        bPaginate:false,
        bFilter:false,
        pageLength: 15,
        "language": {
            "lengthMenu": 'Her sayfada <select>'+
            '<option value="10">10</option>'+
            '<option value="20">20</option>'+
            '<option value="30">30</option>'+
            '<option value="40">40</option>'+
            '<option value="50">50</option>'+
            '<option value="-1">Tümü</option>'+
            '</select> adet göster'
        } 
      
    });
}

/*
* This function activates a select2 dropdown by HTML id name
* 
* @param {HTMLElementInput} input -> <select> tag id to activate
* @param {Array} options -> Options of the select2
* @returns {Function} -> Activate the select2
*/
function activateS2(input, options){
    $('#'+input).select2({
    placeholder: options.placeholder,
    ajax: {
        dataType: 'json',
        url: globalBaseUrl + options.searchUrl,
        data: function (params) {
            return {
                q: params.term, 
                page: params.page
            };
        },
        processResults: function (data, params) {
            params.page = params.page || 1;
            return {
                results: data,
                pagination: {
                  more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; },
});
}

/*
* This function activates a select2 dropdown by HTML class name
* 
* @param {HTMLElementInput} input -> <select> tag class name to activate
* @param {Array} options -> Options of the select2
* @returns {Function} -> Activate the select2
*/
function classS2(input, options){
    $('.'+input).select2({
    placeholder: options.placeholder,
    ajax: {
        dataType: 'json',
        url: globalBaseUrl + options.searchUrl,
        data: function (params) {
            return {
                q: params.term, 
                page: params.page
            };
        },
        processResults: function (data, params) {
            params.page = params.page || 1;
            return {
                results: data,
                pagination: {
                  more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; },
});
}