$(function() {
    // App setup
    window.StyleCI = {};

    // Global Ajax Setup
    $.ajaxPrefilter(function(options, originalOptions, jqXHR) {

        if (! options.beforeSend) {
            options.beforeSend = function(xhr) {
                jqXHR.setRequestHeader('Accept', 'application/json; charset=utf-8');
                jqXHR.setRequestHeader('Content-Type', 'application/json');
            };
        }

        var token;
        if (! options.crossDomain) {
            token = $('meta[name="styleci:token"]').attr('content');
            if (token) {
                jqXHR.setRequestHeader('X-CSRF-Token', token);
            }
        }

        return jqXHR;
    });

    $.ajaxSetup({
        statusCode: {
            401: function() {
                (new StyleCI.Notifier()).notify('You need to be logged in to perform that action. Perhaps your session has expired.');
            },
            403: function() {
                (new StyleCI.Notifier()).notify('Sorry, but you don\'t have permission to perform that action.');
            }
        }
    });

    $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
    $('.js-time-ago').timeago();

    function makeRequest (method, target) {
        if (method === 'GET') {
            window.location.href = target;
            return;
        }

        var token = $('meta[name="styleci:token"]').attr('content');

        var  methodForm = '\n';
        methodForm += '<form action="' + target + '" method="POST" style="display:none">\n';
        methodForm += '<input type="hidden" name="_method" value="' + method + '">\n';
        methodForm += '<input type="hidden" name="_token" value="' + token + '">\n';
        methodForm += '</form>\n';

        $(methodForm).appendTo('body').submit();
    }

    $('body').on('click', '[data-method]', function(e) {
        e.preventDefault();

        var $a = $(this);

        makeRequest($a.data('method'), $a.attr('href'));
    });

    StyleCI.globals = {
        host: window.location.host,
        base_url: window.location.protocol + '//' + window.location.host,
        url: document.URL,
        user: $('meta[name="styleci:user"]').attr('content')
    };

    StyleCI.Events = {};
    StyleCI.Listeners = {};

    StyleCI.Notifier = function() {
        this.notify = function(message, type, options) {
            type = (typeof type === 'undefined' || type === 'error') ? 'danger' : type;
            var $alertsHolder = $('.alerts');

            var defaultOptions = {
                dismiss: false,
            };

            options = _.extend(defaultOptions, options);

            var alertTpl = _.template('<div class="alert alert-<%= type %> styleci-alert"><div class="container"><a class="close" data-dismiss="alert">×</a><%= message %></div></div>');
            $alertsHolder.html(alertTpl({message: message, type: type}));

            $('html, body').animate({
                scrollTop: $('body').offset().top
            }, 500);
        };
    };

    StyleCI.Pusher = (function() {
        var instance;

        function createInstance() {
            return new Pusher($('meta[name="styleci:pusher"]').attr('content'));
        }

        return {
            getInstance: function() {
                if (! instance) {
                    instance = createInstance();
                }
                return instance;
            },
            getChannel: function(ch) {
                return this.getInstance().subscribe(ch);
            }
        };
    })();

    new Vue({
        el: '#app'
    });
});
