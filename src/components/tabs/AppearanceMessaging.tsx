
import React, { useState } from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { MessageSquare, AlertTriangle, Badge as BadgeIcon, Shield, Lock } from 'lucide-react';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import { Badge } from '@/components/ui/badge';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

interface AppearanceMessagingProps {
  settings: {
    showTooltip: boolean;
    showModal: boolean;
    showProtectedBadge: boolean;
    badgePosition: string;
  };
  messages: {
    tooltipText: string;
    alertText: string;
    badgeText: string;
  };
  updateSettings: (key: string, value: any) => void;
  updateMessages: (key: string, value: string) => void;
}

const AppearanceMessaging: React.FC<AppearanceMessagingProps> = ({ 
  settings, 
  messages,
  updateSettings,
  updateMessages
}) => {
  return (
    <div className="space-y-6">
      <Card className="border-[#e0e0e0] shadow-sm hover:shadow-md transition-shadow duration-300">
        <CardHeader className="bg-gradient-to-r from-[#f9f9f9] to-[#f0f0f0]">
          <CardTitle className="flex items-center">
            <MessageSquare className="h-5 w-5 text-[#8B0016] mr-2" />
            User Notifications
          </CardTitle>
          <CardDescription>
            Customize how users are notified about content protection
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4 pt-6">
          <SwitchGroup
            id="show-tooltip"
            label="Show Tooltip on Right Click"
            description="Display a tooltip when users attempt to right-click"
            checked={settings.showTooltip}
            onCheckedChange={(checked) => updateSettings('showTooltip', checked)}
          />
          
          {settings.showTooltip && (
            <div className="ml-6 mt-2 mb-4 animate-fade-in">
              <Label htmlFor="tooltip-text" className="text-sm font-medium">Tooltip Message</Label>
              <Input
                id="tooltip-text"
                placeholder="Content is protected"
                value={messages.tooltipText}
                onChange={(e) => updateMessages('tooltipText', e.target.value)}
                className="mt-1 border-[#e0e0e0] focus-visible:ring-[#0073e6]"
              />
            </div>
          )}
          
          <SwitchGroup
            id="show-modal"
            label="Show Modal/Alert on Unauthorized Action"
            description="Display an alert when protected actions are attempted"
            checked={settings.showModal}
            onCheckedChange={(checked) => updateSettings('showModal', checked)}
          />
          
          {settings.showModal && (
            <div className="ml-6 mt-2 mb-4 animate-fade-in">
              <Label htmlFor="alert-text" className="text-sm font-medium">Alert Message</Label>
              <Textarea
                id="alert-text"
                placeholder="This content is protected. Copying is not allowed."
                value={messages.alertText}
                onChange={(e) => updateMessages('alertText', e.target.value)}
                className="mt-1 border-[#e0e0e0] focus-visible:ring-[#0073e6]"
                rows={3}
              />
            </div>
          )}
        </CardContent>
      </Card>

      <Card className="border-[#e0e0e0] shadow-sm hover:shadow-md transition-shadow duration-300">
        <CardHeader className="bg-gradient-to-r from-[#f9f9f9] to-[#f0f0f0]">
          <CardTitle className="flex items-center">
            <BadgeIcon className="h-5 w-5 text-[#8B0016] mr-2" />
            Protection Badge
          </CardTitle>
          <CardDescription>
            Display a floating badge to indicate content is protected
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4 pt-6">
          <SwitchGroup
            id="show-protected-badge"
            label="'Protected' Badge"
            description="Display a floating badge to indicate content is guarded"
            checked={settings.showProtectedBadge}
            onCheckedChange={(checked) => updateSettings('showProtectedBadge', checked)}
          />
          
          {settings.showProtectedBadge && (
            <div className="ml-6 mt-2 space-y-4 animate-fade-in">
              <div>
                <Label htmlFor="badge-text" className="text-sm font-medium">Badge Text</Label>
                <Input
                  id="badge-text"
                  placeholder="Protected"
                  value={messages.badgeText}
                  onChange={(e) => updateMessages('badgeText', e.target.value)}
                  className="mt-1 border-[#e0e0e0] focus-visible:ring-[#0073e6]"
                />
              </div>
              
              <div>
                <Label htmlFor="badge-position" className="text-sm font-medium">Badge Position</Label>
                <Select 
                  value={settings.badgePosition} 
                  onValueChange={(value) => updateSettings('badgePosition', value)}
                >
                  <SelectTrigger id="badge-position" className="mt-1 border-[#e0e0e0] focus-visible:ring-[#0073e6]">
                    <SelectValue placeholder="Select position" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="top-left">Top Left</SelectItem>
                    <SelectItem value="top-right">Top Right</SelectItem>
                    <SelectItem value="bottom-left">Bottom Left</SelectItem>
                    <SelectItem value="bottom-right">Bottom Right</SelectItem>
                  </SelectContent>
                </Select>
              </div>
              
              <div className="bg-[#F9F9F9] p-4 rounded-md mt-4 border border-[#e0e0e0]">
                <Label className="text-sm font-medium mb-2 block">Preview</Label>
                <div className="relative border border-[#e0e0e0] rounded-md h-48 bg-white shadow-sm">
                  <div className={`absolute ${
                    settings.badgePosition === 'top-left' ? 'top-2 left-2' :
                    settings.badgePosition === 'top-right' ? 'top-2 right-2' :
                    settings.badgePosition === 'bottom-left' ? 'bottom-2 left-2' :
                    'bottom-2 right-2'
                  }`}>
                    <Badge 
                      variant="outline" 
                      className="bg-gradient-to-r from-[#8B0016]/10 to-[#CC0000]/10 text-[#8B0016] border border-[#8B0016]/20 flex items-center gap-1"
                    >
                      <Lock className="h-3 w-3" />
                      {messages.badgeText || 'Protected'}
                    </Badge>
                  </div>
                  <div className="flex items-center justify-center h-full text-gray-400 text-sm">
                    Page content preview
                  </div>
                </div>
              </div>
            </div>
          )}
        </CardContent>
      </Card>
    </div>
  );
};

export default AppearanceMessaging;
