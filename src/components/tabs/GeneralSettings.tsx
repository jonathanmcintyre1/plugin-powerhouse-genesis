
import React from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';

interface GeneralSettingsProps {
  settings: {
    enableProtection: boolean;
    showFrontendNotice: boolean;
    disableForLoggedIn: boolean;
    compatibilityMode: boolean;
  };
  updateSettings: (key: string, value: boolean) => void;
}

const GeneralSettings: React.FC<GeneralSettingsProps> = ({ settings, updateSettings }) => {
  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <CardTitle>Core Protection Settings</CardTitle>
          <CardDescription>
            Configure the global protection behavior for your content
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="enable-protection"
            label="Enable Content Protection"
            description="Master switch to enable or disable all protection features"
            checked={settings.enableProtection}
            onCheckedChange={(checked) => updateSettings('enableProtection', checked)}
          />
          
          <SwitchGroup
            id="show-frontend-notice"
            label="Show Frontend Notice"
            description="Display a subtle 'Content Protected' badge on your pages"
            checked={settings.showFrontendNotice}
            onCheckedChange={(checked) => updateSettings('showFrontendNotice', checked)}
            disabled={!settings.enableProtection}
          />
          
          <SwitchGroup
            id="disable-for-logged-in"
            label="Disable for Logged-in Users"
            description="Allow registered users to freely interact with your content"
            checked={settings.disableForLoggedIn}
            onCheckedChange={(checked) => updateSettings('disableForLoggedIn', checked)}
            disabled={!settings.enableProtection}
          />
          
          <SwitchGroup
            id="compatibility-mode"
            label="Compatibility Mode"
            description="Reduce potential conflicts with other plugins or themes"
            checked={settings.compatibilityMode}
            onCheckedChange={(checked) => updateSettings('compatibilityMode', checked)}
            disabled={!settings.enableProtection}
          />
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Exclusion Rules</CardTitle>
          <CardDescription>
            Exclude specific pages or posts from protection
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            <div>
              <label className="text-sm font-medium">Excluded Pages/Posts</label>
              <div className="flex mt-2">
                <Input 
                  placeholder="Enter page IDs (e.g. 1, 4, 15)" 
                  className="flex-1 mr-2"
                  disabled={!settings.enableProtection}
                />
                <Button 
                  variant="outline"
                  disabled={!settings.enableProtection}
                >
                  Add
                </Button>
              </div>
            </div>
            
            <div className="flex flex-wrap gap-2 mt-3">
              <Badge variant="outline" className="flex items-center gap-1">
                Home Page
                <button className="ml-1 text-gray-500 hover:text-gray-700">×</button>
              </Badge>
              <Badge variant="outline" className="flex items-center gap-1">
                Contact (ID: 12)
                <button className="ml-1 text-gray-500 hover:text-gray-700">×</button>
              </Badge>
              <Badge variant="outline" className="flex items-center gap-1">
                Privacy Policy
                <button className="ml-1 text-gray-500 hover:text-gray-700">×</button>
              </Badge>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  );
};

export default GeneralSettings;
