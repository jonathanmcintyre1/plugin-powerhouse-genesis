
import React, { createContext, useContext, useState } from 'react';

// Define types for all our settings
interface GeneralSettings {
  enableProtection: boolean;
  showFrontendNotice: boolean;
  disableForLoggedIn: boolean;
  compatibilityMode: boolean;
  excludedPages: any[];
}

interface TextSettings {
  disableRightClick: boolean;
  disableTextSelection: boolean;
  disableDragDrop: boolean;
}

interface KeyboardSettings {
  f12: boolean;
  devTools: boolean;
  ctrlA: boolean;
  ctrlC: boolean;
  ctrlV: boolean;
  ctrlX: boolean;
  ctrlF: boolean;
  f3: boolean;
  f6: boolean;
  f9: boolean;
  ctrlH: boolean;
  ctrlL: boolean;
  ctrlK: boolean;
  ctrlO: boolean;
  altD: boolean;
  ctrlS: boolean;
  ctrlP: boolean;
  ctrlU: boolean;
}

interface ImageSettings {
  disableRightClickImages: boolean;
  disableDraggingImages: boolean;
  transparentOverlay: boolean;
  serveCssBackground: boolean;
  preventHotlinking: boolean;
  lazyLoadWithObfuscation: boolean;
}

interface JsSettings {
  disablePrint: boolean;
  disableViewSource: boolean;
  obfuscateHtml: boolean;
  disablePageRefresh: boolean;
  antiInspectTool: boolean;
}

interface AppearanceSettings {
  showTooltip: boolean;
  showModal: boolean;
  showProtectedBadge: boolean;
  badgePosition: string;
}

interface Messages {
  tooltipText: string;
  alertText: string;
  badgeText: string;
}

interface AdvancedSettings {
  enablePerPostType: boolean;
  applyToBlogPosts: boolean;
  applyToPages: boolean;
  applyToProducts: boolean;
  disableForCategories: boolean;
  disabledCategories: any[];
}

export interface SettingsContextType {
  generalSettings: GeneralSettings;
  textSettings: TextSettings;
  keyboardSettings: KeyboardSettings;
  imageSettings: ImageSettings;
  jsSettings: JsSettings;
  appearanceSettings: AppearanceSettings;
  messages: Messages;
  advancedSettings: AdvancedSettings;
  ajaxUrl?: string;
  nonce?: string;
  pluginUrl?: string;
  updateGeneralSettings: (key: string, value: any) => void;
  updateTextSettings: (key: string, value: boolean) => void;
  updateKeyboardSettings: (key: string, value: boolean) => void;
  updateImageSettings: (key: string, value: boolean) => void;
  updateJsSettings: (key: string, value: boolean) => void;
  updateAppearanceSettings: (key: string, value: any) => void;
  updateMessages: (key: string, value: string) => void;
  updateAdvancedSettings: (key: string, value: any) => void;
  hasChanges: boolean;
  setHasChanges: (value: boolean) => void;
}

// Create the context with a default value
const SettingsContext = createContext<SettingsContextType | undefined>(undefined);

// Provider component
interface SettingsProviderProps {
  children: React.ReactNode;
  initialSettings?: {
    generalSettings?: Partial<GeneralSettings>;
    textSettings?: Partial<TextSettings>;
    keyboardSettings?: Partial<KeyboardSettings>;
    imageSettings?: Partial<ImageSettings>;
    jsSettings?: Partial<JsSettings>;
    appearanceSettings?: Partial<AppearanceSettings>;
    messages?: Partial<Messages>;
    advancedSettings?: Partial<AdvancedSettings>;
    ajaxUrl?: string;
    nonce?: string;
    pluginUrl?: string;
  };
}

export const SettingsProvider: React.FC<SettingsProviderProps> = ({ 
  children,
  initialSettings = {}
}) => {
  // Initialize settings with defaults merged with provided initialSettings
  const [generalSettings, setGeneralSettings] = useState<GeneralSettings>({
    enableProtection: false,
    showFrontendNotice: false,
    disableForLoggedIn: false,
    compatibilityMode: false,
    excludedPages: [],
    ...initialSettings?.generalSettings
  });
  
  const [textSettings, setTextSettings] = useState<TextSettings>({
    disableRightClick: false,
    disableTextSelection: false,
    disableDragDrop: false,
    ...initialSettings?.textSettings
  });
  
  const [keyboardSettings, setKeyboardSettings] = useState<KeyboardSettings>({
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
    ...initialSettings?.keyboardSettings
  });
  
  const [imageSettings, setImageSettings] = useState<ImageSettings>({
    disableRightClickImages: false,
    disableDraggingImages: false,
    transparentOverlay: false,
    serveCssBackground: false,
    preventHotlinking: false,
    lazyLoadWithObfuscation: false,
    ...initialSettings?.imageSettings
  });
  
  const [jsSettings, setJsSettings] = useState<JsSettings>({
    disablePrint: false,
    disableViewSource: false,
    obfuscateHtml: false,
    disablePageRefresh: false,
    antiInspectTool: false,
    ...initialSettings?.jsSettings
  });
  
  const [appearanceSettings, setAppearanceSettings] = useState<AppearanceSettings>({
    showTooltip: false,
    showModal: false,
    showProtectedBadge: false,
    badgePosition: 'bottom-right',
    ...initialSettings?.appearanceSettings
  });
  
  const [messages, setMessages] = useState<Messages>({
    tooltipText: 'Content is protected',
    alertText: 'This content is protected. Copying is not allowed.',
    badgeText: 'Protected',
    ...initialSettings?.messages
  });
  
  const [advancedSettings, setAdvancedSettings] = useState<AdvancedSettings>({
    enablePerPostType: false,
    applyToBlogPosts: false,
    applyToPages: false,
    applyToProducts: false,
    disableForCategories: false,
    disabledCategories: [],
    ...initialSettings?.advancedSettings
  });
  
  const [hasChanges, setHasChanges] = useState(false);
  
  // Update functions for each settings group
  const updateGeneralSettings = (key: string, value: any) => {
    setGeneralSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  const updateTextSettings = (key: string, value: boolean) => {
    setTextSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  const updateKeyboardSettings = (key: string, value: boolean) => {
    setKeyboardSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  const updateImageSettings = (key: string, value: boolean) => {
    setImageSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  const updateJsSettings = (key: string, value: boolean) => {
    setJsSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  const updateAppearanceSettings = (key: string, value: any) => {
    setAppearanceSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  const updateMessages = (key: string, value: string) => {
    setMessages(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  const updateAdvancedSettings = (key: string, value: any) => {
    setAdvancedSettings(prev => ({ ...prev, [key]: value }));
    setHasChanges(true);
  };
  
  const contextValue = {
    generalSettings,
    textSettings,
    keyboardSettings,
    imageSettings,
    jsSettings,
    appearanceSettings,
    messages,
    advancedSettings,
    ajaxUrl: initialSettings?.ajaxUrl,
    nonce: initialSettings?.nonce,
    pluginUrl: initialSettings?.pluginUrl,
    updateGeneralSettings,
    updateTextSettings,
    updateKeyboardSettings,
    updateImageSettings,
    updateJsSettings,
    updateAppearanceSettings,
    updateMessages,
    updateAdvancedSettings,
    hasChanges,
    setHasChanges,
  };
  
  return (
    <SettingsContext.Provider value={contextValue}>
      {children}
    </SettingsContext.Provider>
  );
};

// Custom hook to use the settings context
export const useSettings = (): SettingsContextType => {
  const context = useContext(SettingsContext);
  if (!context) {
    throw new Error('useSettings must be used within a SettingsProvider');
  }
  return context;
};
