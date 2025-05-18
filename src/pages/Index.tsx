
import React, { useState } from 'react';
import Header from '@/components/Header';
import TabNavigation from '@/components/TabNavigation';
import SaveChanges from '@/components/SaveChanges';
import TabContent from '@/components/TabContent';
import { SettingsProvider } from '@/contexts/SettingsContext';
import { useSettings } from '@/contexts/SettingsContext';
import { saveSettings } from '@/services/SettingsService';

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

// Component containing the inner content of the page
const IndexContent = () => {
  const [activeTab, setActiveTab] = useState('general');
  const [isSaving, setIsSaving] = useState(false);
  
  const {
    generalSettings,
    textSettings,
    keyboardSettings,
    imageSettings,
    jsSettings,
    appearanceSettings,
    messages,
    advancedSettings,
    ajaxUrl,
    nonce,
    hasChanges,
    setHasChanges
  } = useSettings();
  
  // Handle save using WordPress AJAX
  const handleSave = async () => {
    setIsSaving(true);
    
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
    
    const success = await saveSettings(settingsGroups, ajaxUrl, nonce);
    
    if (success) {
      setHasChanges(false);
    }
    
    setIsSaving(false);
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
                <TabContent activeTab={activeTab} />
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

// Wrapper component that provides the settings context
const Index = ({ initialSettings = {} }: IndexProps) => {
  return (
    <SettingsProvider initialSettings={initialSettings}>
      <IndexContent />
    </SettingsProvider>
  );
};

export default Index;
