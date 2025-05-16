
import React, { useState, useEffect } from 'react';
import Header from '@/components/Header';
import TabNavigation from '@/components/TabNavigation';
import GeneralSettings from '@/components/tabs/GeneralSettings';
import TextProtection from '@/components/tabs/TextProtection';
import ImageProtection from '@/components/tabs/ImageProtection';
import JavaScriptBehavior from '@/components/tabs/JavaScriptBehavior';
import AppearanceMessaging from '@/components/tabs/AppearanceMessaging';
import AdvancedRules from '@/components/tabs/AdvancedRules';
import HelpSupport from '@/components/tabs/HelpSupport';
import KeyboardShortcuts from '@/components/tabs/KeyboardShortcuts';
import SaveChanges from '@/components/SaveChanges';
import { toast } from '@/components/ui/use-toast';

interface IndexProps {
  initialSettings?: {
    generalSettings?: any;
    textSettings?: any;
    keyboardSettings?: any;
    imageSettings?: any;
    jsSettings?: any;
    appearanceSettings?: any;
    messages?: any;
    advancedSettings?: any;
    ajaxUrl?: string;
    nonce?: string;
    pluginUrl?: string;
  };
}

const Index = ({ initialSettings = {} }: IndexProps) => {
  const [activeTab, setActiveTab] = useState('general');
  const [isSaving, setIsSaving] = useState(false);
  const [hasChanges, setHasChanges] = useState(false);
  
  // Initialize settings from WordPress or use defaults
  const [generalSettings, setGeneralSettings] = useState(initialSettings?.generalSettings || {
    enableProtection: false,
    showFrontendNotice: false,
    disableForLoggedIn: false,
    compatibilityMode: false,
    excludedPages: [],
  });
  
  const [textSettings, setTextSettings] = useState(initialSettings?.textSettings || {
    disableRightClick: false,
    disableTextSelection: false,
    disableDragDrop: false,
  });
  
  const [keyboardSettings, setKeyboardSettings] = useState(initialSettings?.keyboardSettings || {
    f12: false,
    devTools: false,
    ctrlA: false,
    ctrlC: false,
    ctrlV: false,
    ctrlX: false,
    ctrlF: false,
    f3: false,
    f6: false,
    f9: false,
    ctrlH: false,
    ctrlL: false,
    ctrlK: false,
    ctrlO: false,
    altD: false,
    ctrlS: false,
    ctrlP: false,
    ctrlU: false,
  });
  
  const [imageSettings, setImageSettings] = useState(initialSettings?.imageSettings || {
    disableRightClickImages: false,
    disableDraggingImages: false,
    transparentOverlay: false,
    serveCssBackground: false,
    preventHotlinking: false,
    lazyLoadWithObfuscation: false,
  });
  
  const [jsSettings, setJsSettings] = useState(initialSettings?.jsSettings || {
    disablePrint: false,
    disableViewSource: false,
    obfuscateHtml: false,
    disablePageRefresh: false,
    antiInspectTool: false,
  });
  
  const [appearanceSettings, setAppearanceSettings] = useState(initialSettings?.appearanceSettings || {
    showTooltip: false,
    showModal: false,
    showProtectedBadge: false,
    badgePosition: 'bottom-right',
  });
  
  const [messages, setMessages] = useState(initialSettings?.messages || {
    tooltipText: 'Content is protected',
    alertText: 'This content is protected. Copying is not allowed.',
    badgeText: 'Protected',
  });
  
  const [advancedSettings, setAdvancedSettings] = useState(initialSettings?.advancedSettings || {
    enablePerPostType: false,
    applyToBlogPosts: false,
    applyToPages: false,
    applyToProducts: false,
    disableForCategories: false,
    disabledCategories: [],
  });

  // Update general settings
  const updateGeneralSettings = (key: string, value: any) => {
    setGeneralSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update text protection settings
  const updateTextSettings = (key: string, value: boolean) => {
    setTextSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update keyboard shortcuts settings
  const updateKeyboardSettings = (key: string, value: boolean) => {
    setKeyboardSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update image protection settings
  const updateImageSettings = (key: string, value: boolean) => {
    setImageSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update JavaScript behavior settings
  const updateJsSettings = (key: string, value: boolean) => {
    setJsSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update appearance & messaging settings
  const updateAppearanceSettings = (key: string, value: any) => {
    setAppearanceSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update messages
  const updateMessages = (key: string, value: string) => {
    setMessages(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update advanced rules settings
  const updateAdvancedSettings = (key: string, value: any) => {
    setAdvancedSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Handle save using WordPress AJAX
  const handleSave = async () => {
    if (!initialSettings?.ajaxUrl || !initialSettings?.nonce) {
      console.error('WordPress AJAX URL or nonce is missing');
      toast({
        title: 'Error',
        description: 'Could not save settings. WordPress configuration is missing.',
        variant: 'destructive',
      });
      return;
    }

    setIsSaving(true);

    try {
      // Save each settings group
      const settingsGroups = [
        { type: 'general_settings', data: generalSettings },
        { type: 'text_settings', data: textSettings },
        { type: 'keyboard_settings', data: keyboardSettings },
        { type: 'image_settings', data: imageSettings },
        { type: 'js_settings', data: jsSettings },
        { type: 'appearance_settings', data: appearanceSettings },
        { type: 'messages', data: messages },
        { type: 'advanced_settings', data: advancedSettings }
      ];

      for (const group of settingsGroups) {
        const formData = new FormData();
        formData.append('action', 'copyprotect_save_settings');
        formData.append('nonce', initialSettings.nonce);
        formData.append('settings_type', group.type);
        formData.append('settings', JSON.stringify(group.data));

        const response = await fetch(initialSettings.ajaxUrl, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin'
        });

        const result = await response.json();
        if (!result.success) {
          throw new Error(`Failed to save ${group.type}: ${result.data}`);
        }
      }

      setHasChanges(false);
      toast({
        title: 'Success',
        description: 'Settings saved successfully.',
      });
    } catch (error) {
      console.error('Error saving settings:', error);
      toast({
        title: 'Error',
        description: 'Failed to save settings. Please try again.',
        variant: 'destructive',
      });
    } finally {
      setIsSaving(false);
    }
  };
  
  // Render the active tab content
  const renderActiveTab = () => {
    switch (activeTab) {
      case 'general':
        return (
          <>
            <GeneralSettings 
              settings={generalSettings} 
              updateSettings={updateGeneralSettings} 
            />
            <AppearanceMessaging 
              settings={appearanceSettings} 
              messages={messages}
              updateSettings={updateAppearanceSettings}
              updateMessages={updateMessages}
            />
          </>
        );
      case 'text':
        return <TextProtection settings={textSettings} updateSettings={updateTextSettings} />;
      case 'keyboard':
        return <KeyboardShortcuts settings={keyboardSettings} updateSettings={updateKeyboardSettings} />;
      case 'image':
        return <ImageProtection settings={imageSettings} updateSettings={updateImageSettings} />;
      case 'javascript':
        return <JavaScriptBehavior settings={jsSettings} updateSettings={updateJsSettings} />;
      case 'advanced':
        return <AdvancedRules settings={advancedSettings} updateSettings={updateAdvancedSettings} />;
      case 'help':
        return <HelpSupport />;
      default:
        return <GeneralSettings settings={generalSettings} updateSettings={updateGeneralSettings} />;
    }
  };
  
  return (
    <div className="min-h-screen bg-gray-100 p-6">
      <div className="max-w-7xl mx-auto">
        <Header />
        
        <div className="flex flex-col md:flex-row gap-6">
          <div className="md:w-64">
            <TabNavigation activeTab={activeTab} setActiveTab={setActiveTab} />
          </div>
          
          <div className="flex-1">
            <div className="bg-white rounded-lg shadow-md overflow-hidden">
              <div className="p-6">
                {renderActiveTab()}
              </div>
              
              <SaveChanges 
                isSaving={isSaving}
                onSave={handleSave}
                hasChanges={hasChanges}
              />
            </div>
          </div>
        </div>
        
        <div className="mt-8 text-center text-gray-500 text-sm">
          CopyProtect – Elegant Content & Image Protection v1.0.0
          <br />
          <a href="#" className="text-[#0073e6] hover:underline">View Documentation</a> | <a href="#" className="text-[#0073e6] hover:underline">Contact Support</a>
        </div>
      </div>
    </div>
  );
};

export default Index;
