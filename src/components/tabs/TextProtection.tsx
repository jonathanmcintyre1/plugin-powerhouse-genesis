
import React from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { KeyRound } from 'lucide-react';

interface TextProtectionProps {
  settings: {
    disableRightClick: boolean;
    disableTextSelection: boolean;
    disableDragDrop: boolean;
    disableKeyboardShortcuts: boolean;
    keyboardShortcuts: {
      ctrlA: boolean;
      ctrlC: boolean;
      ctrlX: boolean;
      ctrlS: boolean;
      ctrlU: boolean;
      f12: boolean;
    };
  };
  updateSettings: (key: string, value: boolean) => void;
  updateNestedSettings: (parent: string, key: string, value: boolean) => void;
}

const TextProtection: React.FC<TextProtectionProps> = ({ 
  settings, 
  updateSettings,
  updateNestedSettings
}) => {
  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <CardTitle>Text Selection Protection</CardTitle>
          <CardDescription>
            Prevent text selection, copying, or dragging text from your content
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="disable-right-click"
            label="Disable Right Click"
            description="Prevents context menu from appearing when right-clicking on text"
            checked={settings.disableRightClick}
            onCheckedChange={(checked) => updateSettings('disableRightClick', checked)}
          />
          
          <SwitchGroup
            id="disable-text-selection"
            label="Disable Text Selection"
            description="Prevents users from selecting and highlighting text on your site"
            checked={settings.disableTextSelection}
            onCheckedChange={(checked) => updateSettings('disableTextSelection', checked)}
          />
          
          <SwitchGroup
            id="disable-drag-drop"
            label="Disable Drag and Drop"
            description="Prevents users from dragging content from your site"
            checked={settings.disableDragDrop}
            onCheckedChange={(checked) => updateSettings('disableDragDrop', checked)}
          />
        </CardContent>
      </Card>

      <Card>
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <div>
            <CardTitle className="flex items-center">
              <KeyRound className="h-5 w-5 text-[#8B0016] mr-2" />
              Keyboard Shortcuts Protection
            </CardTitle>
            <CardDescription>
              Block common keyboard shortcuts used to copy or save content
            </CardDescription>
          </div>
          <SwitchGroup
            id="disable-keyboard-shortcuts"
            label=""
            checked={settings.disableKeyboardShortcuts}
            onCheckedChange={(checked) => updateSettings('disableKeyboardShortcuts', checked)}
            className="border-none p-0 bg-transparent"
          />
        </CardHeader>
        <CardContent className="space-y-4 pt-4">
          <div className="grid grid-cols-2 gap-4">
            <SwitchGroup
              id="ctrl-a"
              label="Ctrl + A (Select All)"
              description="Block the Select All shortcut"
              checked={settings.keyboardShortcuts.ctrlA}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlA', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-c"
              label="Ctrl + C (Copy)"
              description="Block the Copy shortcut"
              checked={settings.keyboardShortcuts.ctrlC}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlC', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-x"
              label="Ctrl + X (Cut)"
              description="Block the Cut shortcut"
              checked={settings.keyboardShortcuts.ctrlX}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlX', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-s"
              label="Ctrl + S (Save)"
              description="Block the Save shortcut"
              checked={settings.keyboardShortcuts.ctrlS}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlS', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-u"
              label="Ctrl + U (View Source)"
              description="Block View Source shortcut"
              checked={settings.keyboardShortcuts.ctrlU}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlU', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="f12"
              label="F12 (Dev Tools)"
              description="Block Developer Tools access"
              checked={settings.keyboardShortcuts.f12}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'f12', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
          </div>
        </CardContent>
      </Card>
    </div>
  );
};

export default TextProtection;
