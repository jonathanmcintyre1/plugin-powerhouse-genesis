
import React, { useState } from 'react';
import Header from '@/components/Header';
import TabNavigation from '@/components/TabNavigation';
import GeneralSettings from '@/components/tabs/GeneralSettings';
import TextProtection from '@/components/tabs/TextProtection';
import ImageProtection from '@/components/tabs/ImageProtection';
import JavaScriptBehavior from '@/components/tabs/JavaScriptBehavior';
import AppearanceMessaging from '@/components/tabs/AppearanceMessaging';
import AdvancedRules from '@/components/tabs/AdvancedRules';
import HelpSupport from '@/components/tabs/HelpSupport';
import SaveChanges from '@/components/SaveChanges';

const Index = () => {
  const [activeTab, setActiveTab] = useState('general');
  const [isSaving, setIsSaving] = useState(false);
  const [hasChanges, setHasChanges] = useState(false);
  
  // General settings - all disabled by default
  const [generalSettings, setGeneralSettings] = useState({
    enableProtection: false,
    showFrontendNotice: false,
    disableForLoggedIn: false,
    compatibilityMode: false,
  });
  
  // Text protection settings - all disabled by default
  const [textSettings, setTextSettings] = useState({
    disableRightClick: false,
    disableRightClickImages: false,
    disableTextSelection: false,
    disableDragDrop: false,
    disableKeyboardShortcuts: false,
    keyboardShortcuts: {
      // Developer tools
      f12: false,
      devTools: false,
      
      // Selection/editing
      ctrlA: false,
      ctrlC: false,
      ctrlV: false,
      ctrlX: false,
      ctrlF: false,
      
      // Navigation/browser
      f3: false,
      f6: false,
      f9: false,
      ctrlH: false,
      ctrlL: false,
      ctrlK: false,
      ctrlO: false,
      altD: false,
      
      // Save/print/view
      ctrlS: false,
      ctrlP: false,
      ctrlU: false,
    },
  });
  
  // Update nested text settings (keyboard shortcuts)
  const updateKeyboardShortcuts = (parent: string, key: string, value: boolean) => {
    if (parent === 'keyboardShortcuts') {
      setTextSettings(prev => ({
        ...prev,
        [parent]: {
          ...prev[parent],
          [key]: value,
        },
      }));
      setHasChanges(true);
    }
  };
  
  // Image protection settings - all disabled by default
  const [imageSettings, setImageSettings] = useState({
    disableRightClickImages: false,
    disableDraggingImages: false,
    transparentOverlay: false,
    serveCssBackground: false,
    preventHotlinking: false,
    lazyLoadWithObfuscation: false,
  });
  
  // JavaScript behavior settings - all disabled by default
  const [jsSettings, setJsSettings] = useState({
    disablePrint: false,
    disableViewSource: false,
    obfuscateHtml: false,
    disablePageRefresh: false,
    antiInspectTool: false,
  });
  
  // Appearance & messaging settings - disabled by default
  const [appearanceSettings, setAppearanceSettings] = useState({
    showTooltip: false,
    showModal: false,
    showProtectedBadge: false,
  });
  
  const [messages, setMessages] = useState({
    tooltipText: 'Content is protected',
    alertText: 'This content is protected. Copying is not allowed.',
    badgeText: 'Protected',
  });
  
  // Advanced rules settings - all disabled by default
  const [advancedSettings, setAdvancedSettings] = useState({
    enablePerPostType: false,
    applyToBlogPosts: false,
    applyToPages: false,
    applyToProducts: false,
    disableForCategories: false,
  });
  
  // Update general settings
  const updateGeneralSettings = (key: string, value: boolean) => {
    setGeneralSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update text protection settings
  const updateTextSettings = (key: string, value: boolean) => {
    setTextSettings(prev => ({ ...prev, [key]: value }));
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
  const updateAppearanceSettings = (key: string, value: boolean) => {
    setAppearanceSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update messages
  const updateMessages = (key: string, value: string) => {
    setMessages(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Update advanced rules settings
  const updateAdvancedSettings = (key: string, value: boolean) => {
    setAdvancedSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  // Handle save
  const handleSave = () => {
    setIsSaving(true);
    
    // Simulate saving to server
    setTimeout(() => {
      setIsSaving(false);
      setHasChanges(false);
      console.log('Settings saved:', {
        generalSettings,
        textSettings,
        imageSettings,
        jsSettings,
        appearanceSettings,
        messages,
        advancedSettings,
      });
    }, 1000);
  };
  
  // Render the active tab content
  const renderActiveTab = () => {
    switch (activeTab) {
      case 'general':
        return <GeneralSettings settings={generalSettings} updateSettings={updateGeneralSettings} />;
      case 'text':
        return <TextProtection 
          settings={textSettings} 
          updateSettings={updateTextSettings}
          updateNestedSettings={updateKeyboardShortcuts}
        />;
      case 'image':
        return <ImageProtection settings={imageSettings} updateSettings={updateImageSettings} />;
      case 'javascript':
        return <JavaScriptBehavior settings={jsSettings} updateSettings={updateJsSettings} />;
      case 'appearance':
        return <AppearanceMessaging 
          settings={appearanceSettings} 
          messages={messages}
          updateSettings={updateAppearanceSettings}
          updateMessages={updateMessages}
        />;
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
