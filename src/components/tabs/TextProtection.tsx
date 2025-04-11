
import React from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Type, MousePointer, GripHorizontal } from 'lucide-react';

interface TextProtectionProps {
  settings: {
    disableRightClick: boolean;
    disableTextSelection: boolean;
    disableDragDrop: boolean;
  };
  updateSettings: (key: string, value: boolean) => void;
}

const TextProtection: React.FC<TextProtectionProps> = ({ settings, updateSettings }) => {
  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <Type className="h-5 w-5 text-[#8B0016] mr-2" />
            Text Only Protection
          </CardTitle>
          <CardDescription>
            Protect text content from being copied or accessed
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="disable-right-click"
            label="Disable Right Click (Entire Site)"
            description="Prevent right-clicking anywhere on your website"
            checked={settings.disableRightClick}
            onCheckedChange={(checked) => updateSettings('disableRightClick', checked)}
          />
          
          <SwitchGroup
            id="disable-text-selection"
            label="Disable Text Selection"
            description="Prevent users from selecting text on your site"
            checked={settings.disableTextSelection}
            onCheckedChange={(checked) => updateSettings('disableTextSelection', checked)}
          />
          
          <SwitchGroup
            id="disable-drag-drop"
            label="Disable Drag and Drop"
            description="Prevent drag and drop functionality that could be used to copy content"
            checked={settings.disableDragDrop}
            onCheckedChange={(checked) => updateSettings('disableDragDrop', checked)}
          />
        </CardContent>
      </Card>
    </div>
  );
};

export default TextProtection;
