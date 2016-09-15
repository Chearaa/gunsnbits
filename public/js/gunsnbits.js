$(function () {

    /**
     * popover @ seatingplan
     */
    $('[data-popover="true"]').popover({
        html: true
    });

    /**
     * tooltip
     */
    $('[data-toggle="tooltip"]').tooltip();

    /**
     * permission switcher
     */
    $('.checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'fa-check-square-o'
                },
                off: {
                    icon: 'fa-square-o'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.fa')
                .removeClass()
                .addClass('fa ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-primary');

                $checkbox.prop('checked', true);
            }
            else {
                $button
                    .removeClass('btn-primary')
                    .addClass('btn-default');

                $checkbox.prop('checked', false);
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.fa').length == 0) {
                $button.prepend('<i class="fa ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });

    /*
    SWITCHER
     */
    $('.switch').each(function() {
        var $switch = $(this);

        $switch.on('click', function() {
            var $this = $(this);

            //delete
            if ($this.hasClass('fa-check-square-o')) {

                $.ajax({
                    type: "GET",
                    url: $this.data('url') + 'delete/' + $this.data('userid') + '/' + $this.data('roleid'),
                    success: function (data) {
                        if(data == 'success') {
                            $this.removeClass('fa-check-square-o');
                            $this.removeClass('text-success');
                            $this.addClass('fa-square-o text-danger');
                        }
                    },
                    error: function (data) {
                    }
                });

            }
            //add
            else {

                $.ajax({
                    type: "GET",
                    url: $this.data('url') + 'add/' + + $this.data('userid') + '/' + $this.data('roleid'),
                    success: function (data) {
                        if(data == 'success') {
                            $this.removeClass('fa-square-o');
                            $this.removeClass('text-danger');
                            $this.addClass('fa-check-square-o text-success');
                        }
                    },
                    error: function (data) {
                    }
                });

            }
        });
    });
});