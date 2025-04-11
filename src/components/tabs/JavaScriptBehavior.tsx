
import React from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { AlertTriangle, Code, Printer, RefreshCw, Shield } from 'lucide-react';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';

interface JavaScriptBehaviorProps {
  settings: {
    disablePrint: boolean;
    disableViewSource: boolean;
    obfuscateHtml: boolean;
    disablePageRefresh: boolean;
    antiInspectTool: boolean;
  };
  updateSettings: (key: string, value: boolean) => void;
}

const JavaScriptBehavior: React.FC<JavaScriptBehaviorProps> = ({ settings, updateSettings }) => {
  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <Code className="h-5 w-5 text-purple-600 mr-2" />
            Browser Interaction Controls
          </CardTitle>
          <CardDescription>
            Customize JavaScript behavior to control browser interactions
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="disable-print"
            label="Disable Print"
            description="Block printing functionality (Ctrl+P) for your content"
            checked={settings.disablePrint}
            onCheckedChange={(checked) => updateSettings('disablePrint', checked)}
          />
          
          <SwitchGroup
            id="disable-view-source"
            label="Disable View Source"
            description="Block right-click > inspect and view-source shortcuts"
            checked={settings.disableViewSource}
            onCheckedChange={(checked) => updateSettings('disableViewSource', checked)}
          />
          
          <SwitchGroup
            id="obfuscate-html"
            label="Obfuscate HTML"
            description="Lightweight JS encoding of DOM until page load to deter scraping"
            checked={settings.obfuscateHtml}
            onCheckedChange={(checked) => updateSettings('obfuscateHtml', checked)}
          />
          
          <SwitchGroup
            id="disable-page-refresh"
            label="Disable Page Refresh"
            description="Prevent users from refreshing the page (use with caution)"
            checked={settings.disablePageRefresh}
            onCheckedChange={(checked) => updateSettings('disablePageRefresh', checked)}
          />
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <Shield className="h-5 w-5 text-purple-600 mr-2" />
            Advanced Protection
          </CardTitle>
          <CardDescription>
            Additional protection features with stronger enforcement
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          {settings.antiInspectTool && (
            <Alert className="mb-4 border-amber-200 bg-amber-50 text-amber-800">
              <AlertTriangle className="h-4 w-4" />
              <AlertTitle>Warning</AlertTitle>
              <AlertDescription>
                This feature can disrupt user experience. Use only if absolutely necessary for content protection.
              </AlertDescription>
            </Alert>
          )}
          
          <SwitchGroup
            id="anti-inspect-tool"
            label="Anti-Inspect Tool"
            description="Blur page or redirect if DevTools opens (use sparingly)"
            checked={settings.antiInspectTool}
            onCheckedChange={(checked) => updateSettings('antiInspectTool', checked)}
          />
        </CardContent>
      </Card>
    </div>
  );
};

export default JavaScriptBehavior;
