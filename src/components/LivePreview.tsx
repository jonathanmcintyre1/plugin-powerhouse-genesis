
import React from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Lock } from 'lucide-react';

const LivePreview: React.FC = () => {
  return (
    <Card className="w-full border-[#e0e0e0] shadow-sm hover:shadow-md transition-shadow duration-300">
      <CardHeader className="bg-gradient-to-r from-[#6a11cb]/5 to-[#2575fc]/5 border-b border-[#e0e0e0]">
        <CardTitle className="text-sm flex items-center">
          <Lock className="h-4 w-4 text-[#6a11cb] mr-2" />
          Live Preview
        </CardTitle>
        <CardDescription className="text-xs">
          See how your settings affect the user experience
        </CardDescription>
      </CardHeader>
      <CardContent className="p-0">
        <div className="relative w-full h-[300px] bg-white border-t border-[#e0e0e0]">
          <iframe 
            title="Content Preview" 
            className="w-full h-full"
            src="about:blank"
          />
          <div className="absolute inset-0 flex items-center justify-center bg-white">
            <div className="text-center p-6">
              <div className="text-[#2575fc] mb-2">
                <img 
                  src="/lovable-uploads/11897506-8ad0-4918-baf8-2256dcae8dbe.png" 
                  alt="CopyProtect Logo" 
                  className="mx-auto h-12 w-12 opacity-50"
                />
              </div>
              <h3 className="text-[#333333] font-medium">Live Preview</h3>
              <p className="text-[#666666] text-sm mt-1">
                Apply settings to see them reflected here
              </p>
            </div>
          </div>
          
          {/* Protection badge example */}
          <div className="absolute bottom-2 right-2">
            <div className="bg-gradient-to-r from-[#6a11cb]/10 to-[#2575fc]/10 text-[#2575fc] border border-[#2575fc]/20 rounded-full px-2 py-1 text-xs flex items-center">
              <Lock className="h-3 w-3 mr-1" />
              Protected
            </div>
          </div>
        </div>
      </CardContent>
    </Card>
  );
};

export default LivePreview;
