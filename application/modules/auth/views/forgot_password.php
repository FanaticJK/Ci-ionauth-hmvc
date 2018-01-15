<?php include "include/header.php"; ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/login.css">
    <!--<h1><?php /*echo lang('forgot_password_heading'); */ ?></h1>
    <p><?php /*echo sprintf(lang('forgot_password_subheading'), $identity_label); */ ?></p>

    <div id="infoMessage"><?php /*echo $message; */ ?></div>

<?php /*echo form_open("auth/forgot_password"); */ ?>

    <p>
        <label for="identity"><?php /*echo(($type == 'email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label)); */ ?></label>
        <br/>
        <?php /*echo form_input($identity); */ ?>
    </p>

    <p><?php /*echo form_submit('submit', lang('forgot_password_submit_btn')); */ ?></p>-->

<?php //echo form_close(); ?>
    <div class="container">

        <div class="row" style="margin-top:20px">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <?php echo form_open("auth/forgot_password"); ?>
                <fieldset>
                    <h2><?php echo lang('forgot_password_heading'); ?></h2>
                    <h5><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></h5>
                    <hr class="colorgraph">
                    <div class="form-group">
                        <?php echo form_input($identity); ?>
                    </div>
                        <a href="<?php echo base_url('auth/login'); ?>" class="btn btn-link">Sign In</a>
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Send Email">
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
<?php include "include/footer.php"; ?>