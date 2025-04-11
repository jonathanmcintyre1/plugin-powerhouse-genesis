
import React from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ImageIcon, Layers, Link } from 'lucide-react';

interface ImageProtectionProps {
  settings: {
    disableRightClickImages: boolean;
    disableDraggingImages: boolean;
    transparentOverlay: boolean;
    serveCssBackground: boolean;
    preventHotlinking: boolean;
    lazyLoadWithObfuscation: boolean;
  };
  updateSettings: (key: string, value: boolean) => void;
}

const ImageProtection: React.FC<ImageProtectionProps> = ({ settings, updateSettings }) => {
  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <ImageIcon className="h-5 w-5 text-[#8B0016] mr-2" />
            Image Only Protection
          </CardTitle>
          <CardDescription>
            Prevent direct saving, dragging, or inspecting images
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="disable-right-click-images"
            label="Disable Right Click on Images Only"
            description="Allow right-clicking on text, but prevent it on images"
            checked={settings.disableRightClickImages}
            onCheckedChange={(checked) => updateSettings('disableRightClickImages', checked)}
          />
          
          <SwitchGroup
            id="disable-dragging-images"
            label="Disable Dragging of Images"
            description="Prevent users from dragging images to save them"
            checked={settings.disableDraggingImages}
            onCheckedChange={(checked) => updateSettings('disableDraggingImages', checked)}
          />
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <Layers className="h-5 w-5 text-[#8B0016] mr-2" />
            Advanced Image Protection
          </CardTitle>
          <CardDescription>
            Advanced methods to protect image sources and prevent saving
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="transparent-overlay"
            label="Transparent Overlay Layer on Images"
            description="Place invisible layer over images to prevent direct interaction"
            checked={settings.transparentOverlay}
            onCheckedChange={(checked) => updateSettings('transparentOverlay', checked)}
          />
          
          <SwitchGroup
            id="serve-css-background"
            label="Serve Images via CSS Background"
            description="Display images as CSS backgrounds to obscure image source"
            checked={settings.serveCssBackground}
            onCheckedChange={(checked) => updateSettings('serveCssBackground', checked)}
          />
          
          <SwitchGroup
            id="prevent-hotlinking"
            label="Prevent Image Hotlinking"
            description="Block other websites from embedding your images directly"
            checked={settings.preventHotlinking}
            onCheckedChange={(checked) => updateSettings('preventHotlinking', checked)}
          />
          
          <SwitchGroup
            id="lazy-load-obfuscation"
            label="Lazy Load with Obfuscation"
            description="Load images with delay & via JS to confuse scraping bots"
            checked={settings.lazyLoadWithObfuscation}
            onCheckedChange={(checked) => updateSettings('lazyLoadWithObfuscation', checked)}
          />
        </CardContent>
      </Card>
    </div>
  );
};

export default ImageProtection;
