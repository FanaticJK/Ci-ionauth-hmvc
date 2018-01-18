<?php include "include/header.php"; ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/login.css">

    <div class="container">

        <div class="row" style="margin-top:20px">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                
                <?php echo form_open("auth/login", array('class' => 'form-signin')); ?>
                <fieldset>
                    <h2><?php echo lang('login_heading'); ?></h2>
                    <hr class="colorgraph">
                    <div class="form-group">
                        <?php echo form_input($identity); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_input($password); ?>
                    </div>
                    <span class="button-checkbox">
                    <button type="button" class="btn" data-color="info">Remember Me</button>
                        <?php echo form_checkbox('remember', '1', FALSE, array('id' => 'remember', 'class' => 'hidden')); ?>
                        <a href="forgot_password"
                           class="btn btn-link pull-right"><?php echo lang('login_forgot_password'); ?></a>
                    </span>
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Sign In">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <input type="reset" class="btn btn-lg btn-danger btn-block">
                        </div>
                    </div>
                </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>

    </div>
    <script>
        $(function () {
            $('.button-checkbox').each(function () {
                var $widget = $(this),
                    $button = $widget.find('button'),
                    $checkbox = $widget.find('input:checkbox'),
                    color = $button.data('color'),
                    settings = {
                        on: {
                            icon: 'glyphicon glyphicon-check'
                        },
                        off: {
                            icon: 'glyphicon glyphicon-unchecked'
                        }
                    };

                $button.on('click', function () {
                    $checkbox.prop('checked', !$checkbox.is(':checked'));
                    $checkbox.triggerHandler('change');
                    updateDisplay();
                });

                $checkbox.on('change', function () {
                    updateDisplay();
                });

                function updateDisplay() {
                    var isChecked = $checkbox.is(':checked');
                    // Set the button's state
                    $button.data('state', (isChecked) ? "on" : "off");

                    // Set the button's icon
                    $button.find('.state-icon')
                        .removeClass()
                        .addClass('state-icon ' + settings[$button.data('state')].icon);

                    // Update the button's color
                    if (isChecked) {
                        $button
                            .removeClass('btn-default')
                            .addClass('btn-' + color + ' active');
                    }
                    else {
                        $button
                            .removeClass('btn-' + color + ' active')
                            .addClass('btn-default');
                    }
                }

                function init() {
                    updateDisplay();
                    // Inject the icon if applicable
                    if ($button.find('.state-icon').length == 0) {
                        $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                    }
                }

                init();
            });
        });
    </script>
<?php include "include/footer.php"; ?>