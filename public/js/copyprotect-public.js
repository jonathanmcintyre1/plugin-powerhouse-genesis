/**
 * Public-facing JavaScript
 */
(function($) {
    'use strict';

    // Main protection function
    function initCopyProtection() {
        var settings = window.copyProtectSettings;
        
        // Only apply protection if enabled for this page/post
        if (!settings || !settings.applyProtection) {
            return;
        }
        
        // Text protection
        if (settings.textProtection) {
            setupTextProtection(settings.textProtection);
        }
        
        // Image protection
        if (settings.imageProtection) {
            setupImageProtection(settings.imageProtection);
        }
        
        // JavaScript behavior protection
        if (settings.jsProtection) {
            setupJsProtection(settings.jsProtection);
        }
        
        // Appearance & messages
        if (settings.appearance) {
            setupAppearance(settings.appearance, settings.messages);
        }
    }
    
    // Set up text protection
    function setupTextProtection(settings) {
        // Disable right click
        if (settings.disableRightClick) {
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                showProtectionNotice('contextmenu');
                return false;
            });
        }
        
        // Disable text selection
        if (settings.disableTextSelection) {
            $('body').addClass('cp-disable-selection');
        }
        
        // Disable drag and drop
        if (settings.disableDragDrop) {
            document.addEventListener('dragstart', function(e) {
                e.preventDefault();
                return false;
            });
        }
        
        // Disable keyboard shortcuts
        if (settings.disableKeyboardShortcuts) {
            document.addEventListener('keydown', function(e) {
                var key = e.key.toLowerCase();
                var ctrl = e.ctrlKey || e.metaKey;
                
                // Check for specific shortcuts
                if (ctrl && settings.keyboardShortcuts) {
                    // Ctrl+A (Select All)
                    if (key === 'a' && settings.keyboardShortcuts.ctrlA) {
                        e.preventDefault();
                        showProtectionNotice('keyboard');
                        return false;
                    }
                    
                    // Ctrl+C (Copy)
                    if (key === 'c' && settings.keyboardShortcuts.ctrlC) {
                        e.preventDefault();
                        showProtectionNotice('keyboard');
                        return false;
                    }
                    
                    // Ctrl+X (Cut)
                    if (key === 'x' && settings.keyboardShortcuts.ctrlX) {
                        e.preventDefault();
                        showProtectionNotice('keyboard');
                        return false;
                    }
                    
                    // Ctrl+S (Save)
                    if (key === 's' && settings.keyboardShortcuts.ctrlS) {
                        e.preventDefault();
                        showProtectionNotice('keyboard');
                        return false;
                    }
                    
                    // Ctrl+U (View Source)
                    if (key === 'u' && settings.keyboardShortcuts.ctrlU) {
                        e.preventDefault();
                        showProtectionNotice('keyboard');
                        return false;
                    }
                }
                
                // F12 (Dev Tools)
                if (e.key === 'F12' && settings.keyboardShortcuts && settings.keyboardShortcuts.f12) {
                    e.preventDefault();
                    showProtectionNotice('keyboard');
                    return false;
                }
            });
        }
    }
    
    // Set up image protection
    function setupImageProtection(settings) {
        // Disable right click on images
        if (settings.disableRightClickImages) {
            $('img').on('contextmenu', function(e) {
                e.preventDefault();
                showProtectionNotice('image');
                return false;
            });
        }
        
        // Disable dragging of images
        if (settings.disableDraggingImages) {
            $('img').attr('draggable', 'false');
            $('img').on('dragstart', function(e) {
                e.preventDefault();
                return false;
            });
        }
        
        // Add transparent overlay to images
        if (settings.transparentOverlay) {
            $('img').each(function() {
                var $img = $(this);
                var position = $img.css('position');
                
                // Make sure the image has positioning to allow overlay
                if (position !== 'relative' && position !== 'absolute') {
                    $img.css('position', 'relative');
                }
                
                // Add overlay
                $img.wrap('<div style="display:inline-block; position:relative;"></div>');
                $img.after('<div class="copyprotect-overlay"></div>');
            });
        }
        
        // Serve images via CSS background
        if (settings.serveCssBackground) {
            $('img').each(function() {
                var $img = $(this);
                var imgSrc = $img.attr('src');
                var imgWidth = $img.width();
                var imgHeight = $img.height();
                var imgAlt = $img.attr('alt') || '';
                
                if (imgSrc && imgWidth && imgHeight) {
                    var $container = $('<div class="copyprotect-bg-container" aria-label="' + imgAlt + '"></div>');
                    $container.css({
                        width: imgWidth + 'px',
                        height: imgHeight + 'px',
                        display: 'inline-block',
                        backgroundImage: 'url(' + imgSrc + ')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center'
                    });
                    
                    $img.replaceWith($container);
                }
            });
        }
        
        // Lazy load with obfuscation
        if (settings.lazyLoadWithObfuscation) {
            $('img').each(function() {
                var $img = $(this);
                var imgSrc = $img.attr('src');
                
                if (imgSrc) {
                    // Replace src with data attribute and lazy load
                    $img.attr('data-src', imgSrc);
                    $img.removeAttr('src');
                    
                    // Add placeholder
                    $img.attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
                }
            });
            
            // Lazy load when in viewport
            $(window).on('scroll', function() {
                $('img[data-src]').each(function() {
                    var $img = $(this);
                    var rect = $img[0].getBoundingClientRect();
                    
                    if (
                        rect.top >= 0 &&
                        rect.left >= 0 &&
                        rect.top <= (window.innerHeight || document.documentElement.clientHeight)
                    ) {
                        // Load the image
                        $img.attr('src', $img.attr('data-src'));
                        $img.removeAttr('data-src');
                    }
                });
            }).trigger('scroll');
        }
    }
    
    // Set up JavaScript behavior protection
    function setupJsProtection(settings) {
        // Disable print
        if (settings.disablePrint) {
            window.addEventListener('beforeprint', function(e) {
                e.preventDefault();
                showProtectionNotice('print');
                return false;
            });
            
            // Additional check for Ctrl+P
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'p') {
                    e.preventDefault();
                    showProtectionNotice('print');
                    return false;
                }
            });
        }
        
        // Disable view source
        if (settings.disableViewSource) {
            // Already handled in keyboard shortcuts
        }
        
        // Obfuscate HTML
        if (settings.obfuscateHtml) {
            // Simple DOM obfuscation technique (will be decoded after page loads)
            var contentElements = document.querySelectorAll('.entry-content, article, .post-content, .page-content, main');
            
            contentElements.forEach(function(element) {
                // Save original content
                var originalContent = element.innerHTML;
                
                // Apply simple encoding
                var encodedContent = btoa(originalContent);
                element.innerHTML = '<div data-protected="true" style="opacity: 0.01;">' + encodedContent + '</div>';
                
                // Decode after a short delay
                setTimeout(function() {
                    var protectedElements = element.querySelectorAll('[data-protected="true"]');
                    protectedElements.forEach(function(protectedElement) {
                        try {
                            var decoded = atob(protectedElement.textContent);
                            element.innerHTML = decoded;
                        } catch(e) {
                            // Fallback to original content
                            element.innerHTML = originalContent;
                        }
                    });
                }, 500);
            });
        }
        
        // Disable page refresh
        if (settings.disablePageRefresh) {
            window.addEventListener('beforeunload', function(e) {
                e.preventDefault();
                e.returnValue = '';
                return '';
            });
        }
        
        // Anti-inspect tool
        if (settings.antiInspectTool) {
            // Detect DevTools opening
            var devToolsTimeout;
            var isDevToolsOpen = false;
            
            function checkDevTools() {
                var widthThreshold = window.outerWidth - window.innerWidth > 160;
                var heightThreshold = window.outerHeight - window.innerHeight > 160;
                
                if (widthThreshold || heightThreshold) {
                    if (!isDevToolsOpen) {
                        isDevToolsOpen = true;
                        onDevToolsOpen();
                    }
                } else {
                    if (isDevToolsOpen) {
                        isDevToolsOpen = false;
                        onDevToolsClose();
                    }
                }
                
                devToolsTimeout = setTimeout(checkDevTools, 1000);
            }
            
            function onDevToolsOpen() {
                // Blur the content
                document.body.classList.add('copyprotect-blur');
                
                // Show warning
                showProtectionNotice('inspect');
            }
            
            function onDevToolsClose() {
                // Remove blur
                document.body.classList.remove('copyprotect-blur');
            }
            
            checkDevTools();
        }
    }
    
    // Set up appearance and messaging
    function setupAppearance(appearance, messages) {
        // Variables to store tooltip element
        var $tooltip = null;
        var tooltipTimeout = null;
        
        // Function to show tooltip
        function showTooltip(message, x, y) {
            // Remove any existing tooltip
            hideTooltip();
            
            // Create tooltip
            $tooltip = $('<div class="copyprotect-tooltip"></div>').text(message);
            $('body').append($tooltip);
            
            // Position tooltip
            var tooltipWidth = $tooltip.outerWidth();
            var tooltipHeight = $tooltip.outerHeight();
            
            var posX = x - (tooltipWidth / 2);
            var posY = y - tooltipHeight - 10;
            
            // Keep tooltip in viewport
            if (posX < 0) posX = 0;
            if (posX + tooltipWidth > $(window).width()) posX = $(window).width() - tooltipWidth;
            if (posY < 0) posY = y + 20;
            
            $tooltip.css({
                left: posX + 'px',
                top: posY + 'px'
            });
            
            // Auto-hide tooltip after delay
            tooltipTimeout = setTimeout(hideTooltip, 2000);
        }
        
        // Function to hide tooltip
        function hideTooltip() {
            if ($tooltip) {
                $tooltip.remove();
                $tooltip = null;
            }
            
            if (tooltipTimeout) {
                clearTimeout(tooltipTimeout);
                tooltipTimeout = null;
            }
        }
        
        // Tooltip on right click
        if (appearance.showTooltip) {
            document.addEventListener('contextmenu', function(e) {
                var tooltipText = messages.tooltipText || 'Content is protected';
                showTooltip(tooltipText, e.clientX, e.clientY);
            });
        }
    }
    
    // Function to show protection notice based on action
    function showProtectionNotice(action) {
        var settings = window.copyProtectSettings;
        
        if (!settings || !settings.appearance || !settings.messages) {
            return;
        }
        
        // Show tooltip on action
        if (settings.appearance.showTooltip) {
            var tooltipText = settings.messages.tooltipText || 'Content is protected';
            var x = window.event ? window.event.clientX : 100;
            var y = window.event ? window.event.clientY : 100;
            
            // Create tooltip element
            var tooltip = document.createElement('div');
            tooltip.className = 'copyprotect-tooltip';
            tooltip.textContent = tooltipText;
            document.body.appendChild(tooltip);
            
            // Position tooltip
            var tooltipWidth = tooltip.offsetWidth;
            var tooltipHeight = tooltip.offsetHeight;
            
            tooltip.style.left = (x - (tooltipWidth / 2)) + 'px';
            tooltip.style.top = (y - tooltipHeight - 10) + 'px';
            
            // Auto-remove tooltip
            setTimeout(function() {
                document.body.removeChild(tooltip);
            }, 2000);
        }
        
        // Show modal/alert
        if (settings.appearance.showModal) {
            var alertText = settings.messages.alertText || 'This content is protected. Copying is not allowed.';
            alert(alertText);
        }
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        initCopyProtection();
    });

})(jQuery);
