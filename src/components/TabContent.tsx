
import React from 'react';
import GeneralSettings from '@/components/tabs/GeneralSettings';
import TextProtection from '@/components/tabs/TextProtection';
import ImageProtection from '@/components/tabs/ImageProtection';
import JavaScriptBehavior from '@/components/tabs/JavaScriptBehavior';
import AppearanceMessaging from '@/components/tabs/AppearanceMessaging';
import AdvancedRules from '@/components/tabs/AdvancedRules';
import HelpSupport from '@/components/tabs/HelpSupport';
import KeyboardShortcuts from '@/components/tabs/KeyboardShortcuts';
import { useSettings } from '@/contexts/SettingsContext';

interface TabContentProps {
  activeTab: string;
}

const TabContent: React.FC<TabContentProps> = ({ activeTab }) => {
  const {
    generalSettings,
    textSettings,
    keyboardSettings,
    imageSettings,
    jsSettings,
    appearanceSettings,
    messages,
    advancedSettings,
    updateGeneralSettings,
    updateTextSettings,
    updateKeyboardSettings,
    updateImageSettings,
    updateJsSettings,
    updateAppearanceSettings,
    updateMessages,
    updateAdvancedSettings
  } = useSettings();

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

export default TabContent;
