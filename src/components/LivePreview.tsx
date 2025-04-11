
import React from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Shield } from 'lucide-react';

const LivePreview: React.FC = () => {
  return (
    <Card className="w-full">
      <CardHeader className="bg-gray-50 border-b">
        <CardTitle className="text-sm flex items-center">
          <Shield className="h-4 w-4 text-purple-600 mr-2" />
          Live Preview
        </CardTitle>
        <CardDescription className="text-xs">
          See how your settings affect the user experience
        </CardDescription>
      </CardHeader>
      <CardContent className="p-0">
        <div className="relative w-full h-[300px] bg-white border-t border-gray-100">
          <iframe 
            title="Content Preview" 
            className="w-full h-full"
            src="about:blank"
          />
          <div className="absolute inset-0 flex items-center justify-center bg-white">
            <div className="text-center p-6">
              <div className="text-gray-400 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="mx-auto">
                  <rect width="18" height="18" x="3" y="3" rx="2" />
                  <path d="M7 7h.01" />
                  <path d="M11 7h.01" />
                  <path d="M15 7h.01" />
                  <path d="M7 11h.01" />
                  <path d="M11 11h.01" />
                  <path d="M15 11h.01" />
                  <path d="M7 15h.01" />
                  <path d="M11 15h.01" />
                  <path d="M15 15h.01" />
                </svg>
              </div>
              <h3 className="text-gray-600 font-medium">Live Preview</h3>
              <p className="text-gray-500 text-sm mt-1">
                Apply settings to see them reflected here
              </p>
            </div>
          </div>
          
          {/* Protection badge example */}
          <div className="absolute bottom-2 right-2">
            <div className="bg-purple-50 text-purple-800 border border-purple-200 rounded-full px-2 py-1 text-xs flex items-center">
              <Shield className="h-3 w-3 mr-1" />
              Protected
            </div>
          </div>
        </div>
      </CardContent>
    </Card>
  );
};

export default LivePreview;
