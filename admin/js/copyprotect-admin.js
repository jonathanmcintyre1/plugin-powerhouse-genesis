
/**
 * Admin JavaScript
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        // Tab navigation
        $('.nav-tab').on('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs and content
            $('.nav-tab').removeClass('nav-tab-active');
            $('.tab-pane').removeClass('active');
            
            // Add active class to clicked tab
            $(this).addClass('nav-tab-active');
            
            // Show corresponding content
            var target = $(this).attr('href');
            $(target).addClass('active');
        });

        // Initialize - show the first tab
        if (!window.location.hash) {
            $('.nav-tab:first').click();
        } else {
            // If URL has hash, activate that tab
            $('.nav-tab[href="' + window.location.hash + '"]').click();
        }

        // Toggle dependent options
        $('.toggle-control').on('change', function() {
            var isChecked = $(this).is(':checked');
            var parentRow = $(this).closest('tr');
            
            // Find the appropriate options container to toggle
            if (parentRow.hasClass('disable-categories-option')) {
                $('.category-selection').toggle(isChecked);
            } else {
                // Find toggleable options based on the toggle control
                var toggleId = $(this).attr('id');
                var toggleName = $(this).attr('name');
                
                // Handle each specific toggle case
                if (toggleName.includes('disableKeyboardShortcuts')) {
                    $('.shortcut-options').toggle(isChecked);
                } else if (toggleName.includes('showTooltip')) {
                    $('.tooltip-options').toggle(isChecked);
                } else if (toggleName.includes('showModal')) {
                    $('.modal-options').toggle(isChecked);
                } else if (toggleName.includes('showProtectedBadge')) {
                    $('.badge-options').toggle(isChecked);
                } else if (toggleName.includes('enablePerPostType')) {
                    $('.post-type-options').toggle(isChecked);
                } else if (toggleName.includes('applyToBlogPosts')) {
                    $('.disable-categories-option').toggle(isChecked);
                }
            }
        });
    });
})(jQuery);
