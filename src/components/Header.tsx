
import React from 'react';
import { Shield } from 'lucide-react';

const Header = () => {
  return (
    <div className="flex items-center justify-between mb-8 bg-gradient-to-r from-purple-700 to-indigo-800 p-6 rounded-lg shadow-md">
      <div className="flex items-center space-x-3">
        <div className="bg-white p-3 rounded-full shadow-inner">
          <Shield className="h-8 w-8 text-purple-700" />
        </div>
        <div>
          <h1 className="text-2xl font-bold text-white">Content Guard</h1>
          <p className="text-purple-200 text-sm">Elegant Content & Image Protection</p>
        </div>
      </div>
      <div className="bg-purple-600 text-white text-xs px-3 py-1 rounded-full font-medium">
        Version 1.0.0
      </div>
    </div>
  );
};

export default Header;
