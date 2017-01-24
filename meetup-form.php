<?php
/*
Plugin Name: Meetup Form
Plugin URI:http://www.fflab.info
Description: Contact Form Plugin demo for MeetUpPc - shortcode: [mpc_contact_form]
Version: 1.0
Author: Meetup-PC
Author URI: http://www.fflab.info
*/
function mpc_html_form_code() {
  echo '<form action="' .esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
  echo '<p>';
  echo 'Il tuo Nome <br>';
  echo '<input type="text" name="mpc-name" pattern="[a-zA-Z0-9]+" value="' . ( isset($_POST["mpc-name"]) ? esc_attr( $_POST["mpc-name"]) : '' ) . '" size=40></p>';
  echo '<p>La tua email <br>';
  echo '<input type="email" name="mpc-email" value="' . ( isset($_POST["mpc-email"]) ? esc_attr( $_POST["mpc-email"]) : '' ) . '" size=40></p>';
  echo 'Oggetto <br/>';
	echo '<input type="text" name="mpc-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["mpc-subject"] ) ? esc_attr( $_POST["mpc-subject"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>Il tuo messaggio <br/>';
	echo '<textarea rows="10" cols="35" name="mpc-message">' . ( isset( $_POST["mpc-message"] ) ? esc_attr( $_POST["mpc-message"] ) : '' ) . '</textarea>';
	echo '</p>';
	echo '<p><input type="submit" name="mpc-submitted" value="Invia"></p>';
	echo '</form>';
}

function deliver_mail(){
    //se il bottone di submit è cliccato invia la mail
    // vedere su codex il sanitize per ogni tipo di input
    // text= sanitize_text_field ecc.
    if ( isset ( $_POST['mpc-submitted'] ) ) {
        // sanitize dei valori della form
        $name = sanitize_text_field( $_POST["mpc-name"]);
        $email = sanitize_email( $_POST["mpc-email"]);
        $subject = sanitize_text_field( $_POST["mpc-subject"] );
        $message = esc_textarea( $_POST["mpc-message"]);

        //ottieni l'indirizzo email dell'admin
        $to = get_option( 'admin_email' );
        //$to = 'example@gmail.com';
         $headers = "Da: $name <$email>" . "\r\n";

        //messaggio di successo o fail
        if ( wp_mail( $to, $subject, $message, $headers ))

        {
        $mpc_result = '<div><p>Grazie per avere scritto. A presto ti risponderemo.</p></div>';
        } else {
        $mpc_result= '<p>Invio non riuscito!</p>';
        }
        echo $mpc_result;
    }
}
 // Codice per creare lo short code per inserire la form nella pagina che vogliamo
function mpc_shortcode(){
    ob_start();
    deliver_mail();
    mpc_html_form_code();
}

add_shortcode( 'mpc_contact_form', 'mpc_shortcode');

?>
