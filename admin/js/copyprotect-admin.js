
/**
 * Admin JavaScript for CopyProtect
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        // Tab navigation - using on() instead of click() shorthand
        $('.nav-tab-wrapper').on('click', '.nav-tab', function(e) {
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
            $('.nav-tab:first').trigger('click');
        } else {
            // If URL has hash, activate that tab
            $('.nav-tab[href="' + window.location.hash + '"]').trigger('click');
        }

        // Toggle dependent options - using on() instead of change() shorthand
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
                if (toggleName.includes('showTooltip')) {
                    $('.tooltip-options').toggle(isChecked);
                } else if (toggleName.includes('showModal')) {
                    $('.modal-options').toggle(isChecked);
                } else if (toggleName.includes('showProtectedBadge')) {
                    $('.badge-options').toggle(isChecked);
                } else if (toggleName.includes('enablePerPostType')) {
                    $('.post-type-options').toggle(isChecked);
                }
            }
        });

        // Page exclusion functionality
        var excludedPages = [];
        
        // Add page to exclusion list
        $('#add-exclusion').on('click', function() {
            var pageId = $('#excluded-page-id').val();
            var pageName = $('#excluded-page-id option:selected').text();
            
            if (pageId && !excludedPages.includes(pageId)) {
                excludedPages.push(pageId);
                
                // Add to visual list
                var itemHtml = '<span class="excluded-item" data-id="' + pageId + '">' + 
                               pageName + 
                               '<button type="button" class="excluded-item-remove">×</button>' +
                               '</span>';
                               
                $('.exclusion-list').append(itemHtml);
                
                // Update hidden input
                $('#excluded-pages').val(excludedPages.join(','));
                
                // Reset select
                $('#excluded-page-id').val('');
            }
        });
        
        // Remove page from exclusion list
        $('.exclusion-list').on('click', '.excluded-item-remove', function() {
            var item = $(this).parent('.excluded-item');
            var pageId = item.data('id');
            
            // Remove from array
            excludedPages = excludedPages.filter(function(id) {
                return id != pageId;
            });
            
            // Remove from DOM
            item.remove();
            
            // Update hidden input
            $('#excluded-pages').val(excludedPages.join(','));
        });
        
        // Initialize tooltips and badge position previews
        $('#badge-position').on('change', function() {
            updateBadgePosition($(this).val());
        });
        
        function updateBadgePosition(position) {
            var badge = $('.preview-badge');
            badge.css({top: '', right: '', bottom: '', left: ''});
            
            switch(position) {
                case 'top-left':
                    badge.css({top: '10px', left: '10px'});
                    break;
                case 'top-right':
                    badge.css({top: '10px', right: '10px'});
                    break;
                case 'bottom-left':
                    badge.css({bottom: '10px', left: '10px'});
                    break;
                case 'bottom-right':
                    badge.css({bottom: '10px', right: '10px'});
                    break;
            }
        }
        
        // Initialize with default position
        updateBadgePosition($('#badge-position').val() || 'bottom-right');
    });
})(jQuery);
