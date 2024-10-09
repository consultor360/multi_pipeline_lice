<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php echo _l('multi_pipeline_license_settings'); ?></h4>
                        <hr class="hr-panel-heading" />
                        
                        <?php echo form_open(admin_url('multi_pipeline/validate_license')); ?>
                        <div id="license-validation-section">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="validate-license-btn"><?php echo _l('validate_license'); ?></button>
                            </div>
                        </div>
                        <div id="license-key-section" style="display: none;">
                            <div class="form-group">
                                <label for="license_key"><?php echo _l('license_key'); ?></label>
                                <input type="text" id="license_key" name="license_key" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><?php echo _l('activate'); ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
$(function() {
    $('#validate-license-btn').on('click', function(e) {
        e.preventDefault();
        $.post(admin_url + 'multi_pipeline/validate_license', function(response) {
            if (response.success) {
                $('#license-validation-section').hide();
                $('#license-key-section').show();
                alert(response.message);
            } else {
                alert('Erro: ' + response.message);
            }
        }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
            alert('Erro na requisição: ' + textStatus + ' - ' + errorThrown);
        });
    });
});
</script>