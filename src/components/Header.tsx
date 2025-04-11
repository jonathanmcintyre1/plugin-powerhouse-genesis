
import React from 'react';
import { Lock } from 'lucide-react';

const Header = () => {
  return (
    <div className="relative mb-8 overflow-hidden rounded-lg shadow-md">
      {/* Primary gradient background */}
      <div className="bg-gradient-to-r from-[#8B0016] to-[#CC0000] p-6">
        <div className="flex items-center justify-between">
          <div className="flex items-center space-x-3">
            <div className="flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-inner">
              <img 
                src="/lovable-uploads/11897506-8ad0-4918-baf8-2256dcae8dbe.png" 
                alt="CopyProtect Logo" 
                className="h-10 w-10"
              />
            </div>
            <div>
              <h1 className="text-2xl font-bold text-white">CopyProtect</h1>
              <p className="text-sm text-red-100">Elegant Content & Image Protection</p>
            </div>
          </div>
          <div className="bg-white/20 backdrop-blur-sm text-white text-xs px-3 py-1 rounded-full font-medium">
            Version 1.0.0
          </div>
        </div>
      </div>
    </div>
  );
};

export default Header;
