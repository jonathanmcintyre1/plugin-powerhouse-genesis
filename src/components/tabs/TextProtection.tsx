
import React from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { KeyRound, Mouse, Shield } from 'lucide-react';
import { Separator } from '@/components/ui/separator';

interface TextProtectionProps {
  settings: {
    disableRightClick: boolean;
    disableRightClickImages: boolean;
    disableTextSelection: boolean;
    disableDragDrop: boolean;
    disableKeyboardShortcuts: boolean;
    keyboardShortcuts: {
      // Developer tools
      f12: boolean;
      devTools: boolean;
      
      // Selection/editing
      ctrlA: boolean;
      ctrlC: boolean;
      ctrlV: boolean;
      ctrlX: boolean;
      ctrlF: boolean;
      
      // Navigation/browser
      f3: boolean;
      f6: boolean;
      f9: boolean;
      ctrlH: boolean;
      ctrlL: boolean;
      ctrlK: boolean;
      ctrlO: boolean;
      altD: boolean;
      
      // Save/print/view
      ctrlS: boolean;
      ctrlP: boolean;
      ctrlU: boolean;
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
          <CardTitle className="flex items-center">
            <Mouse className="h-5 w-5 text-[#8B0016] mr-2" />
            Mouse & Context Menu Protection
          </CardTitle>
          <CardDescription>
            Control right-clicking and mouse interactions with your content
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="disable-right-click"
            label="Disable Right Click – Entire Site"
            description="Prevents the context menu from appearing when right-clicking anywhere on your site"
            checked={settings.disableRightClick}
            onCheckedChange={(checked) => updateSettings('disableRightClick', checked)}
          />
          
          <SwitchGroup
            id="disable-right-click-images"
            label="Disable Right Click on Images Only"
            description="Only prevents right-clicking specifically on images while allowing it elsewhere"
            checked={settings.disableRightClickImages}
            onCheckedChange={(checked) => updateSettings('disableRightClickImages', checked)}
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
              Block keyboard shortcuts used to copy, save, or inspect content
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
          <h3 className="text-sm font-medium">Developer Tools Protection</h3>
          <div className="grid grid-cols-2 gap-4 mb-6">
            <SwitchGroup
              id="dev-tools"
              label="Disable Developer Tools (F12, Ctrl+Shift+I, Cmd+Opt+I)"
              description="Block keyboard combinations that open dev tools"
              checked={settings.keyboardShortcuts.devTools}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'devTools', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="f12"
              label="Disable F12 Key"
              description="Block F12 key to prevent dev tools access"
              checked={settings.keyboardShortcuts.f12}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'f12', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
          </div>
          
          <Separator className="my-4" />
          
          <h3 className="text-sm font-medium">Text Selection & Copying</h3>
          <div className="grid grid-cols-2 gap-4 mb-6">
            <SwitchGroup
              id="ctrl-a"
              label="Disable Ctrl+A / Cmd+A (Select All)"
              description="Block the Select All shortcut"
              checked={settings.keyboardShortcuts.ctrlA}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlA', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-c"
              label="Disable Ctrl+C / Cmd+C (Copy)"
              description="Block the Copy shortcut"
              checked={settings.keyboardShortcuts.ctrlC}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlC', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-v"
              label="Disable Ctrl+V / Cmd+V (Paste)"
              description="Block the Paste shortcut"
              checked={settings.keyboardShortcuts.ctrlV}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlV', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-x"
              label="Disable Ctrl+X / Cmd+X (Cut)"
              description="Block the Cut shortcut"
              checked={settings.keyboardShortcuts.ctrlX}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlX', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-f"
              label="Disable Ctrl+F / Cmd+F (Find)"
              description="Block the Find/Search shortcut"
              checked={settings.keyboardShortcuts.ctrlF}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlF', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
          </div>
          
          <Separator className="my-4" />
          
          <h3 className="text-sm font-medium">Navigation & Browser Actions</h3>
          <div className="grid grid-cols-2 gap-4 mb-6">
            <SwitchGroup
              id="f3"
              label="Disable F3 Key (Find Next)"
              description="Block the F3 key used for search/find"
              checked={settings.keyboardShortcuts.f3}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'f3', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="f6"
              label="Disable F6 Key (Address Bar)"
              description="Block F6 key used to focus address bar"
              checked={settings.keyboardShortcuts.f6}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'f6', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="f9"
              label="Disable F9 Key"
              description="Block F9 key used in some browsers"
              checked={settings.keyboardShortcuts.f9}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'f9', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-h"
              label="Disable Ctrl+H / Cmd+Y (History)"
              description="Block access to browser history"
              checked={settings.keyboardShortcuts.ctrlH}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlH', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-l"
              label="Disable Ctrl+L / Cmd+L (Address Bar)"
              description="Block shortcut for focusing address bar"
              checked={settings.keyboardShortcuts.ctrlL}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlL', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-k"
              label="Disable Ctrl+K / Cmd+K (Search)"
              description="Block browser search shortcuts"
              checked={settings.keyboardShortcuts.ctrlK}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlK', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-o"
              label="Disable Ctrl+O / Cmd+O (Open File)"
              description="Block shortcut for opening files"
              checked={settings.keyboardShortcuts.ctrlO}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlO', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="alt-d"
              label="Disable Alt+D / Cmd+D (Bookmark)"
              description="Block shortcut for bookmarking pages"
              checked={settings.keyboardShortcuts.altD}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'altD', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
          </div>
          
          <Separator className="my-4" />
          
          <h3 className="text-sm font-medium">Save, Print & View</h3>
          <div className="grid grid-cols-2 gap-4">            
            <SwitchGroup
              id="ctrl-s"
              label="Disable Ctrl+S / Cmd+S (Save)"
              description="Block the Save shortcut"
              checked={settings.keyboardShortcuts.ctrlS}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlS', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-p"
              label="Disable Ctrl+P / Cmd+P (Print)"
              description="Block the Print shortcut"
              checked={settings.keyboardShortcuts.ctrlP}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlP', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
            
            <SwitchGroup
              id="ctrl-u"
              label="Disable Ctrl+U / Cmd+U (View Source)"
              description="Block View Source shortcut"
              checked={settings.keyboardShortcuts.ctrlU}
              onCheckedChange={(checked) => updateNestedSettings('keyboardShortcuts', 'ctrlU', checked)}
              disabled={!settings.disableKeyboardShortcuts}
            />
          </div>
        </CardContent>
      </Card>
    </div>
  );
};

export default TextProtection;
