
import React from 'react';
import { cn } from '@/lib/utils';
import {
  Settings, Type, Image, Code, MessageSquare, List, HelpCircle, Keyboard
} from 'lucide-react';

type TabItem = {
  id: string;
  label: string;
  icon: React.ReactNode;
};

interface TabNavigationProps {
  activeTab: string;
  setActiveTab: (tab: string) => void;
}

const TabNavigation: React.FC<TabNavigationProps> = ({ activeTab, setActiveTab }) => {
  const tabs: TabItem[] = [
    { id: 'general', label: 'General Settings', icon: <Settings className="h-5 w-5" /> },
    { id: 'text', label: 'Text Only Protection', icon: <Type className="h-5 w-5" /> },
    { id: 'image', label: 'Image Only Protection', icon: <Image className="h-5 w-5" /> },
    { id: 'keyboard', label: 'Keyboard Shortcuts', icon: <Keyboard className="h-5 w-5" /> },
    { id: 'javascript', label: 'JavaScript Behavior', icon: <Code className="h-5 w-5" /> },
    { id: 'advanced', label: 'Advanced Rules', icon: <List className="h-5 w-5" /> },
    { id: 'help', label: 'Help & Support', icon: <HelpCircle className="h-5 w-5" /> },
  ];

  return (
    <div className="flex flex-col bg-white rounded-lg shadow-md mb-6 p-2 w-64 space-y-1">
      {tabs.map((tab) => (
        <button
          key={tab.id}
          onClick={() => setActiveTab(tab.id)}
          className={cn(
            "flex items-center space-x-3 px-4 py-3 text-left rounded-md transition-all duration-200",
            activeTab === tab.id
              ? "bg-gradient-to-r from-[#2D2D2D] to-[#0073e6]/90 text-white font-medium"
              : "text-[#444444] bg-white hover:bg-gray-50"
          )}
        >
          <span className={cn(
            "transition-colors duration-200",
            activeTab === tab.id ? "text-white" : "text-[#444444]"
          )}>
            {tab.icon}
          </span>
          <span>{tab.label}</span>
        </button>
      ))}
    </div>
  );
};

export default TabNavigation;
