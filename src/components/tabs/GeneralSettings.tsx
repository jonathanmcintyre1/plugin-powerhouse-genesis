
import React from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { XCircle } from 'lucide-react';

interface GeneralSettingsProps {
  settings: {
    enableProtection: boolean;
    showFrontendNotice: boolean;
    disableForLoggedIn: boolean;
    compatibilityMode: boolean;
    excludedPages: any[];
  };
  updateSettings: (key: string, value: any) => void;
}

const GeneralSettings: React.FC<GeneralSettingsProps> = ({ settings, updateSettings }) => {
  // Mock data for WordPress pages - in reality this would be pulled from the server
  const sitePages = [
    { id: 1, title: 'Home' },
    { id: 2, title: 'About Us' },
    { id: 3, title: 'Contact' },
    { id: 4, title: 'Blog' },
    { id: 5, title: 'Privacy Policy' },
    { id: 6, title: 'Terms of Service' },
  ];
  
  const [selectedPageId, setSelectedPageId] = React.useState<string>('');
  
  const addExcludedPage = () => {
    if (!selectedPageId) return;
    
    const pageId = parseInt(selectedPageId);
    const pageExists = settings.excludedPages.some(page => page.id === pageId);
    
    if (!pageExists) {
      const page = sitePages.find(p => p.id === pageId);
      if (page) {
        const newExcludedPages = [...settings.excludedPages, page];
        updateSettings('excludedPages', newExcludedPages);
        setSelectedPageId('');
      }
    }
  };
  
  const removeExcludedPage = (pageId: number) => {
    const newExcludedPages = settings.excludedPages.filter(page => page.id !== pageId);
    updateSettings('excludedPages', newExcludedPages);
  };
  
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
          <CardTitle>Page Exclusion Rules</CardTitle>
          <CardDescription>
            Select specific pages or posts to exclude from protection
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            <div>
              <label className="text-sm font-medium block mb-2">Select Page to Exclude</label>
              <div className="flex">
                <Select 
                  value={selectedPageId} 
                  onValueChange={setSelectedPageId}
                  disabled={!settings.enableProtection}
                >
                  <SelectTrigger className="flex-1 mr-2">
                    <SelectValue placeholder="Select a page to exclude" />
                  </SelectTrigger>
                  <SelectContent>
                    {sitePages.map(page => (
                      <SelectItem key={page.id} value={page.id.toString()}>
                        {page.title}
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
                <Button 
                  variant="outline"
                  onClick={addExcludedPage}
                  disabled={!settings.enableProtection || !selectedPageId}
                >
                  Add
                </Button>
              </div>
            </div>
            
            <div>
              <label className="text-sm font-medium block mb-2">Excluded Pages</label>
              {settings.excludedPages.length === 0 ? (
                <div className="text-sm text-gray-500 italic">No pages excluded. Protection will apply to all content.</div>
              ) : (
                <div className="flex flex-wrap gap-2 mt-3">
                  {settings.excludedPages.map(page => (
                    <Badge key={page.id} variant="outline" className="flex items-center gap-1">
                      {page.title} (ID: {page.id})
                      <button 
                        className="ml-1 text-gray-500 hover:text-[#8B0016]"
                        onClick={() => removeExcludedPage(page.id)}
                        type="button"
                      >
                        <XCircle className="h-3.5 w-3.5" />
                      </button>
                    </Badge>
                  ))}
                </div>
              )}
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  );
};

export default GeneralSettings;
