
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
import LivePreview from '@/components/LivePreview';
import SaveChanges from '@/components/SaveChanges';

const Index = () => {
  const [activeTab, setActiveTab] = useState('general');
  const [isSaving, setIsSaving] = useState(false);
  const [hasChanges, setHasChanges] = useState(false);
  
  // General settings
  const [generalSettings, setGeneralSettings] = useState({
    enableProtection: false,
    showFrontendNotice: false,
    disableForLoggedIn: true,
    compatibilityMode: false,
  });
  
  // Text protection settings
  const [textSettings, setTextSettings] = useState({
    disableRightClick: true,
    disableTextSelection: true,
    disableDragDrop: true,
    disableKeyboardShortcuts: true,
    keyboardShortcuts: {
      ctrlA: true,
      ctrlC: true,
      ctrlX: true,
      ctrlS: true,
      ctrlU: true,
      f12: true,
    },
  });
  
  // Image protection settings
  const [imageSettings, setImageSettings] = useState({
    disableRightClickImages: true,
    disableDraggingImages: true,
    transparentOverlay: false,
    serveCssBackground: false,
    preventHotlinking: true,
    lazyLoadWithObfuscation: false,
  });
  
  // JavaScript behavior settings
  const [jsSettings, setJsSettings] = useState({
    disablePrint: true,
    disableViewSource: true,
    obfuscateHtml: false,
    disablePageRefresh: false,
    antiInspectTool: false,
  });
  
  // Appearance & messaging settings
  const [appearanceSettings, setAppearanceSettings] = useState({
    showTooltip: true,
    showModal: false,
    showProtectedBadge: true,
  });
  
  const [messages, setMessages] = useState({
    tooltipText: 'Content is protected',
    alertText: 'This content is protected. Copying is not allowed.',
    badgeText: 'Protected',
  });
  
  // Advanced rules settings
  const [advancedSettings, setAdvancedSettings] = useState({
    enablePerPostType: false,
    applyToBlogPosts: true,
    applyToPages: true,
    applyToProducts: true,
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
  
  // Update nested text settings (keyboard shortcuts)
  const updateKeyboardShortcuts = (parent: string, key: string, value: boolean) => {
    setTextSettings(prev => ({
      ...prev,
      [parent]: {
        ...prev[parent as keyof typeof prev],
        [key]: value,
      },
    }));
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
            <LivePreview />
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
          Content Guard – Elegant Content & Image Protection v1.0.0
          <br />
          <a href="#" className="text-purple-600 hover:underline">View Documentation</a> | <a href="#" className="text-purple-600 hover:underline">Contact Support</a>
        </div>
      </div>
    </div>
  );
};

export default Index;
