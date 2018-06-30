<?php

namespace CN\Registration;

// redirect logged in users
add_filter('login_redirect', __NAMESPACE__.'\\login_redirect', 10, 3);
function login_redirect($redirect_to, $request, $user) {
    if ( !current_user_can("manage_options") ) {
        return home_url( site_url('/film/') );
    }
    return $redirect_to;
}


add_action( 'woocommerce_edit_account_form', __NAMESPACE__ . '\\woocommerce_exta_field' );
add_action( 'woocommerce_register_form_start', __NAMESPACE__ . '\\woocommerce_exta_field' );

function woocommerce_exta_field() {

    $skype =  '';

    if ( ! empty( $_POST['skype'] ) ) {
        $skype =  sanitize_text_field( $_POST['skype'] );
    }
    else if ( is_user_logged_in() ) {
        $skype = get_user_meta( get_current_user_id(), 'skype', true );
    }

    ?><p class="form-row form-row-wide"><label for="reg_skype"><?php _e( 'Skype', 'cn' ); ?> *</label><input type="text" class="input-text" name="skype" id="reg_skype" value="<?php echo esc_attr( $skype ); ?>" /></p><div class="clear"></div><?php
}

/**
 * register fields Validating.
 */
add_action( 'woocommerce_register_post', function ( $username, $email, $validation_errors ) {

    if ( empty( $_POST['skype'] ) ) {
        $validation_errors->add( 'skype_error', __( 'Please enter your Skype ID.', 'cn' ) );
    }
     return $validation_errors;
}, 10, 3);

/**
 * Front end registration
 */

add_action( 'register_form', __NAMESPACE__.'\\registration_form' );
function registration_form() {

    $skype = ! empty( $_POST['skype'] ) ? sanitize_text_field( $_POST['skype'] ) : '';

    ?>
    <p>
        <label for="skype"><?php esc_html_e( 'Skype', 'cn' ) ?><br/>
            <input type="text"
                   id="skype"
                   name="skype"
                   value="<?php echo esc_attr( $skype ); ?>"
                   class="input"
            />
        </label>
    </p>
    <?php
}

add_filter( 'registration_errors', __NAMESPACE__.'\\registration_errors', 10, 3 );
function registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( empty( $_POST['skype'] ) ) {
        $errors->add( 'skype_error', __( '<strong>ERROR</strong>: Please enter your Skype ID.', 'cn' ) );
    }


    return $errors;
}

add_action( 'user_register', __NAMESPACE__.'\\user_register' );
add_action( 'woocommerce_created_customer', __NAMESPACE__.'\\user_register' );  // WOO
add_action( 'woocommerce_save_account_details', __NAMESPACE__.'\\user_register' );  // WOO

function user_register( $user_id ) {
    if ( ! empty( $_POST['skype'] ) ) {
        update_user_meta( $user_id, 'skype', sanitize_text_field($_POST['skype'] ) );
    }
}

/**
 * Back end registration
 */

add_action( 'user_new_form', __NAMESPACE__.'\\crf_admin_registration_form' );
function admin_registration_form( $operation ) {
    if ( 'add-new-user' !== $operation ) {
        // $operation may also be 'add-existing-user'
        return;
    }

    $skype = ! empty( $_POST['skype'] ) ? sanitize_text_field( $_POST['skype'] ) : '';

    ?>
    <h3><?php esc_html_e( 'Personal Information', 'cn' ); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="skype"><?php esc_html_e( 'Skype', 'cn' ); ?></label> <span class="description"><?php esc_html_e( '(required)', 'cn' ); ?></span></th>
            <td>
                <input type="text"
                       id="skype"
                       name="skype"
                       value="<?php echo esc_attr( $skype ); ?>"
                       class="regular-text"
                />
            </td>
        </tr>
    </table>
    <?php
}

add_action( 'user_profile_update_errors', __NAMESPACE__.'\\user_profile_update_errors', 10, 3 );
function user_profile_update_errors( $errors, $update, $user ) {
    if ( $update ) {
        return;
    }
    
    if ( empty( $_POST['skype'] ) ) {
        $errors->add( 'skype_error', __( '<strong>ERROR</strong>: Please enter your Skype ID.', 'cn' ) );
    }

}

add_action( 'edit_user_created_user', __NAMESPACE__.'\\user_register' );


/**
 * Back end display
 */

add_action( 'show_user_profile', __NAMESPACE__.'\\show_extra_profile_fields' );
add_action( 'edit_user_profile', __NAMESPACE__.'\\show_extra_profile_fields' );

function show_extra_profile_fields( $user ) {
    ?>
    <h3><?php esc_html_e( 'Personal Information', 'cn' ); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="skype"><?php esc_html_e( 'Skype', 'cn' ); ?></label></th>
            <td><?php echo esc_html( get_the_author_meta( 'Skype', $user->ID ) ); ?></td>
        </tr>
    </table>
    <?php
}