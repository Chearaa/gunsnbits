$(function () {
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

    $('.switch').each(function() {
        var $switch = $(this);

        $switch.on('click', function() {
            if ($this.hasClass('fa-check-square-o')) {
                $this.removeClass('fa-check-square-o');
                $this.addClass('fa-square-o');
            }
            else {
                $this.removeClass('fa-square-o');
                $this.addClass('fa-check-square-o');
            }
        });
    });
});