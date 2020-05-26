<?php
defined('ABSPATH') || exit;

/**
 * Check if ACF Pro and ACFE are activated
 */
add_action( 'after_plugin_row_' . PIP_PI_BASENAME, 'pip_pi_plugin_row', 5, 3 );
function pip_pi_plugin_row( $plugin_file, $plugin_data, $status ) {

    // If ACF Pro, ACFE & PiloPress are activated, return
    if ( pip_pi_addon()->has_acf() && pip_pi_addon()->has_acfe()  && pip_pi_addon()->has_pip() ) {
        return;
    }

    ?>

    <style>
        .plugins tr[data-plugin='<?php echo PIP_PI_BASENAME; ?>'] th,
        .plugins tr[data-plugin='<?php echo PIP_PI_BASENAME; ?>'] td {
            box-shadow: none;
        }

        <?php if(isset($plugin_data['update']) && !empty($plugin_data['update'])){ ?>

        .plugins tr.pilopress-pilotin-addon-plugin-tr td {
            box-shadow: none !important;
        }

        .plugins tr.pilopress-pilotin-addon-plugin-tr .update-message {
            margin-bottom: 0;
        }

        <?php } ?>
    </style>

    <tr class="plugin-update-tr active pilopress-pilotin-addon-plugin-tr">
        <td colspan="3" class="plugin-update colspanchange">
            <div class="update-message notice inline notice-error notice-alt">
                <p><?php _e( 'Pilo\'Press - Pilot\'in Addon requires Advanced Custom Fields PRO (minimum: 5.7.13), ACF Extended & PiloPress.', 'pip-pi-addon' ); ?></p>
            </div>
        </td>
    </tr>

    <?php

}
