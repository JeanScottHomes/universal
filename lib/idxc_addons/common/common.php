<?php
/*
*
* Miscellaneous functions specific to Add-ons
*
*/


// Add Modal for Agent specific Contact Information
add_action('genesis_before_footer', 'add_agent_contact_modal');
function add_agent_contact_modal() {
    $image = cmb2_get_option('md_main_options', 'contact_modal_image');
    
    // Check if $image exists and is not empty
    $styleAttribute = $image ? "background-image: url($image);background-size: cover;" : "background-color:#111;";

    $shortcodeOutput = do_shortcode('[agent_contact1_modal]');
    $customHtml = <<<HTML
<div class="md_modal isc_modal_contact1" id="modal_agent_contact1" aria-hidden="true" aria-label="Contact Agent Information" tabindex="-1" role="dialog" style="$styleAttribute">
    <div class="isc_modal_content">
        <button class="md_modal_close" data-modal-close="modal_agent_contact1" aria-label="Close Modal">X</button>
        <div class="md_modal_dialog">
            <div class="md_modal_body">
                <div class="iul_form_transparent">$shortcodeOutput</div>
                <a href="#" class="visuallyhidden" aria-hidden="true">End of Modal</a>
            </div>
        </div>
    </div>
</div>
HTML;

    echo $customHtml;
}