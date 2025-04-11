
import React from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Keyboard, Terminal, Type, Globe, Save } from 'lucide-react';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';

interface KeyboardShortcutsProps {
  settings: {
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
  };
  updateSettings: (key: string, value: boolean) => void;
}

const KeyboardShortcuts: React.FC<KeyboardShortcutsProps> = ({ settings, updateSettings }) => {
  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <Terminal className="h-5 w-5 text-[#8B0016] mr-2" />
            Developer Tools Protection
          </CardTitle>
          <CardDescription>
            Prevent access to browser developer tools and inspection features
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="f12-key"
            label="Disable F12 Key"
            description="Block F12 key that opens developer tools"
            checked={settings.f12}
            onCheckedChange={(checked) => updateSettings('f12', checked)}
          />
          
          <SwitchGroup
            id="dev-tools-shortcut"
            label="Disable Developer Tools Shortcuts (Ctrl+Shift+I / Cmd+Opt+I)"
            description="Block keyboard combinations that open developer tools"
            checked={settings.devTools}
            onCheckedChange={(checked) => updateSettings('devTools', checked)}
          />
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <Type className="h-5 w-5 text-[#8B0016] mr-2" />
            Text Selection & Editing Shortcuts
          </CardTitle>
          <CardDescription>
            Prevent keyboard shortcuts for text manipulation and selection
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="ctrl-a"
            label="Disable Ctrl+A / Cmd+A"
            description="Prevent selecting all content on the page"
            checked={settings.ctrlA}
            onCheckedChange={(checked) => updateSettings('ctrlA', checked)}
          />
          
          <SwitchGroup
            id="ctrl-c"
            label="Disable Ctrl+C / Cmd+C"
            description="Block copying of content via keyboard shortcut"
            checked={settings.ctrlC}
            onCheckedChange={(checked) => updateSettings('ctrlC', checked)}
          />
          
          <SwitchGroup
            id="ctrl-v"
            label="Disable Ctrl+V / Cmd+V"
            description="Prevent pasting content via keyboard shortcut"
            checked={settings.ctrlV}
            onCheckedChange={(checked) => updateSettings('ctrlV', checked)}
          />
          
          <SwitchGroup
            id="ctrl-x"
            label="Disable Ctrl+X / Cmd+X"
            description="Block cutting content via keyboard shortcut"
            checked={settings.ctrlX}
            onCheckedChange={(checked) => updateSettings('ctrlX', checked)}
          />
          
          <SwitchGroup
            id="ctrl-f"
            label="Disable Ctrl+F / Cmd+F"
            description="Prevent using find/search functionality"
            checked={settings.ctrlF}
            onCheckedChange={(checked) => updateSettings('ctrlF', checked)}
          />
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <Globe className="h-5 w-5 text-[#8B0016] mr-2" />
            Browser Navigation Shortcuts
          </CardTitle>
          <CardDescription>
            Block keyboard shortcuts for browser navigation and controls
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="f3-key"
            label="Disable F3 Key"
            description="Block the F3 key (in-page search)"
            checked={settings.f3}
            onCheckedChange={(checked) => updateSettings('f3', checked)}
          />
          
          <SwitchGroup
            id="f6-key"
            label="Disable F6 Key"
            description="Prevent F6 key (address bar focus)"
            checked={settings.f6}
            onCheckedChange={(checked) => updateSettings('f6', checked)}
          />
          
          <SwitchGroup
            id="f9-key"
            label="Disable F9 Key"
            description="Block the F9 key (browser-specific functions)"
            checked={settings.f9}
            onCheckedChange={(checked) => updateSettings('f9', checked)}
          />
          
          <SwitchGroup
            id="ctrl-h"
            label="Disable Ctrl+H / Cmd+Y"
            description="Prevent access to browser history"
            checked={settings.ctrlH}
            onCheckedChange={(checked) => updateSettings('ctrlH', checked)}
          />
          
          <SwitchGroup
            id="ctrl-l"
            label="Disable Ctrl+L / Cmd+L"
            description="Block address bar focus shortcut"
            checked={settings.ctrlL}
            onCheckedChange={(checked) => updateSettings('ctrlL', checked)}
          />
          
          <SwitchGroup
            id="ctrl-k"
            label="Disable Ctrl+K / Cmd+K"
            description="Prevent browser search shortcuts"
            checked={settings.ctrlK}
            onCheckedChange={(checked) => updateSettings('ctrlK', checked)}
          />
          
          <SwitchGroup
            id="ctrl-o"
            label="Disable Ctrl+O / Cmd+O"
            description="Block opening file shortcuts"
            checked={settings.ctrlO}
            onCheckedChange={(checked) => updateSettings('ctrlO', checked)}
          />
          
          <SwitchGroup
            id="alt-d"
            label="Disable Alt+D / Cmd+D"
            description="Prevent bookmark page shortcuts"
            checked={settings.altD}
            onCheckedChange={(checked) => updateSettings('altD', checked)}
          />
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <Save className="h-5 w-5 text-[#8B0016] mr-2" />
            Save & Print Shortcuts
          </CardTitle>
          <CardDescription>
            Block shortcuts for saving, printing, or viewing page source
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="ctrl-s"
            label="Disable Ctrl+S / Cmd+S"
            description="Prevent saving page via keyboard shortcut"
            checked={settings.ctrlS}
            onCheckedChange={(checked) => updateSettings('ctrlS', checked)}
          />
          
          <SwitchGroup
            id="ctrl-p"
            label="Disable Ctrl+P / Cmd+P"
            description="Block printing page via keyboard shortcut"
            checked={settings.ctrlP}
            onCheckedChange={(checked) => updateSettings('ctrlP', checked)}
          />
          
          <SwitchGroup
            id="ctrl-u"
            label="Disable Ctrl+U / Cmd+U"
            description="Prevent view source via keyboard shortcut"
            checked={settings.ctrlU}
            onCheckedChange={(checked) => updateSettings('ctrlU', checked)}
          />
        </CardContent>
      </Card>
    </div>
  );
};

export default KeyboardShortcuts;
